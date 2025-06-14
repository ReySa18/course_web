<template>
  <div class="quiz-container">
    <!-- Navbar -->
    <div class="quiz-navbar">
      <button class="back-button" @click="goBack">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
        Kembali
      </button>
      <h1 class="quiz-title">{{ topic }}</h1>
    </div>

    <div class="quiz-content">
      <!-- Overview Panel -->
      <div class="overview-panel">
        <h2 class="overview-title">Daftar Soal</h2>
        <div class="question-grid">
          <div 
            v-for="(question, index) in questions" 
            :key="index"
            class="question-card"
            :class="{
              'current': currentQuestion === index,
              'answered': question.answered,
              'unanswered': !question.answered
            }"
            @click="goToQuestion(index)"
          >
            {{ index + 1 }}
          </div>
        </div>
        <div class="progress-container">
          <div class="progress-bar">
            <div class="progress-fill" :style="{ width: progress + '%' }"></div>
          </div>
          <div class="progress-text">{{ answeredCount }} / {{ questions.length }} terjawab</div>
        </div>
      </div>

      <!-- Question Area -->
      <div class="question-area">
        <div class="question-display">
          <div class="question-header">
            <div class="question-number">Soal {{ currentQuestion + 1 }}</div>
            <div class="question-status" :class="currentQuestionData.answered ? 'answered' : 'unanswered'">
              {{ currentQuestionData.answered ? 'Terjawab' : 'Belum Dijawab' }}
            </div>
          </div>
          
          <div class="question-text">{{ currentQuestionData.question }}</div>
          
          <div class="options-container">
            <div 
              v-for="(option, index) in currentQuestionData.options" 
              :key="index"
              class="option-item"
              :class="{ 
                'selected': currentQuestionData.selected === index,
                'correct': showAnswers && index === currentQuestionData.correctAnswer
              }"
              @click="selectOption(index)"
            >
              <div class="option-letter">{{ String.fromCharCode(65 + index) }}</div>
              <div class="option-text">{{ option }}</div>
            </div>
          </div>
        </div>

        <div class="question-navigation">
          <button 
            class="nav-button prev-button" 
            :disabled="currentQuestion === 0"
            @click="prevQuestion"
          >
            Sebelumnya
          </button>
          <button 
            class="nav-button next-button" 
            :disabled="currentQuestion === questions.length - 1"
            @click="nextQuestion"
          >
            Selanjutnya
          </button>
          <button 
            class="submit-button" 
            v-if="answeredCount === questions.length"
            @click="submitQuiz"
          >
            Selesaikan Kuis
          </button>
        </div>
      </div>
    </div>

    <!-- Notification -->
    <div v-if="notification.show" class="notification" :class="notification.type">
      {{ notification.message }}
    </div>
  </div>
</template>

<script>
export default {
  name: 'QuizPage',
  data() {
    return {
      topic: "Pemrograman Web Lanjut",
      currentQuestion: 0,
      showAnswers: false,
      notification: {
        show: false,
        message: '',
        type: ''
      },
      questions: [
        {
          question: "Manakah dari berikut ini yang BUKAN merupakan framework JavaScript?",
          options: ["React", "Vue", "Angular", "Django", "Svelte"],
          answered: false,
          selected: null,
          correctAnswer: 3
        },
        {
          question: "Apa kepanjangan dari SPA dalam konteks pengembangan web?",
          options: ["Single Page Application", "Server Page Application", "Structured Programming Approach", "Secure Protocol Architecture", "Simple Page Architecture"],
          answered: false,
          selected: null,
          correctAnswer: 0
        },
        {
          question: "Manakah yang merupakan hook Vue untuk memantau perubahan data?",
          options: ["onMounted", "computed", "watch", "ref", "reactive"],
          answered: false,
          selected: null,
          correctAnswer: 2
        },
        {
          question: "Apa tujuan utama dari Vuex dalam ekosistem Vue?",
          options: ["Routing", "State Management", "Server Communication", "UI Components", "Form Validation"],
          answered: false,
          selected: null,
          correctAnswer: 1
        },
        {
          question: "Metode HTTP manakah yang digunakan untuk memperbarui data di server?",
          options: ["GET", "POST", "PUT", "DELETE", "HEAD"],
          answered: false,
          selected: null,
          correctAnswer: 2
        },
        {
          question: "Manakah dari berikut ini yang BUKAN konsep pemrograman fungsional?",
          options: ["Immutability", "Pure Functions", "Side Effects", "Class Inheritance", "Higher-Order Functions"],
          answered: false,
          selected: null,
          correctAnswer: 3
        },
        {
          question: "Apa yang dimaksud dengan CORS dalam pengembangan web?",
          options: ["Cross-Origin Resource Sharing", "Centralized Object Request System", "Component-Oriented Routing Service", "Cascading Object Response Syntax", "Client-Side Origin Resolution"],
          answered: false,
          selected: null,
          correctAnswer: 0
        },
        {
          question: "Manakah yang merupakan fitur ES6 JavaScript?",
          options: ["Arrow Functions", "Callback Functions", "Prototype Inheritance", "XMLHttpRequest", "IIFE"],
          answered: false,
          selected: null,
          correctAnswer: 0
        },
        {
          question: "Apa fungsi utama dari npm dalam ekosistem JavaScript?",
          options: ["Package Management", "Native Platform Modules", "Network Performance Monitoring", "New Project Management", "Node Process Manager"],
          answered: false,
          selected: null,
          correctAnswer: 0
        },
        {
          question: "Manakah yang BUKAN merupakan metode lifecycle Vue?",
          options: ["created", "mounted", "updated", "destroyed", "initialized"],
          answered: false,
          selected: null,
          correctAnswer: 4
        }
      ]
    };
  },
  computed: {
    currentQuestionData() {
      return this.questions[this.currentQuestion];
    },
    answeredCount() {
      return this.questions.filter(q => q.answered).length;
    },
    progress() {
      return (this.answeredCount / this.questions.length) * 100;
    }
  },
  methods: {
    goBack() {
      this.showNotification("Kuis disimpan sebagai draft", "info");
    },
    goToQuestion(index) {
      this.currentQuestion = index;
    },
    prevQuestion() {
      if (this.currentQuestion > 0) {
        this.currentQuestion--;
      }
    },
    nextQuestion() {
      if (this.currentQuestion < this.questions.length - 1) {
        this.currentQuestion++;
      }
    },
    selectOption(index) {
      this.currentQuestionData.selected = index;
      this.currentQuestionData.answered = true;
      
      if (!this.showAnswers) {
        setTimeout(() => {
          if (this.currentQuestion < this.questions.length - 1) {
            this.currentQuestion++;
          }
        }, 500);
      }
    },
    submitQuiz() {
      this.showAnswers = true;
      this.showNotification("Kuis berhasil diselesaikan!", "success");
    },
    showNotification(message, type) {
      this.notification = {
        show: true,
        message,
        type
      };
      
      setTimeout(() => {
        this.notification.show = false;
      }, 3000);
    }
  }
};
</script>

<style>
.vue-app, [data-v-app] {
  margin: 0 !important;
  padding: 0 !important;
}

.quiz-container {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  width: 100vw;
  background: linear-gradient(135deg, #000000 0%, #1a1a1a 50%, #000000 100%);
  color: #ffffff;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.quiz-navbar {
  display: flex;
  align-items: center;
  padding: 20px;
  background: rgba(10, 10, 10, 0.8);
  border-bottom: 1px solid #333;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
  position: sticky;
  top: 0;
  z-index: 100;
}

.back-button {
  display: flex;
  align-items: center;
  gap: 8px;
  background: linear-gradient(to right, #4a00e0, #8e2de2);
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 50px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.back-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 15px rgba(142, 45, 226, 0.4);
}

.back-button:active {
  transform: translateY(0);
}

.quiz-title {
  flex: 1;
  text-align: center;
  margin: 0;
  font-size: 1.8rem;
  font-weight: 700;
  letter-spacing: 0.5px;
  background: linear-gradient(to right, #00c6ff, #0072ff);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.quiz-content {
  display: flex;
  flex: 1;
  padding: 20px;
  gap: 20px;
  max-width: 1400px;
  margin: 0 auto;
  width: 100%;
}

.overview-panel {
  flex: 0 0 280px;
  background: rgba(30, 30, 30, 0.8);
  border-radius: 15px;
  padding: 20px;
  border: 1px solid #333;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
  backdrop-filter: blur(5px);
  display: flex;
  flex-direction: column;
}

.overview-title {
  margin-top: 0;
  margin-bottom: 20px;
  font-size: 1.4rem;
  color: #e0e0e0;
  text-align: center;
  padding-bottom: 10px;
  border-bottom: 1px solid #444;
}

.question-grid {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 12px;
  margin-bottom: 20px;
}

.question-card {
  display: flex;
  align-items: center;
  justify-content: center;
  aspect-ratio: 1;
  border-radius: 10px;
  font-weight: 700;
  font-size: 1.2rem;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.question-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
}

.unanswered {
  background: rgba(60, 60, 60, 0.7);
  border: 2px solid #444;
  color: #aaa;
}

.answered {
  background: linear-gradient(135deg, #00b09b, #96c93d);
  color: white;
  border: 2px solid #00b09b;
}

.current {
  background: linear-gradient(135deg, #2193b0, #6dd5ed);
  color: white;
  border: 2px solid #2193b0;
  transform: scale(1.1);
  box-shadow: 0 0 20px rgba(33, 147, 176, 0.5);
}

.progress-container {
  margin-top: auto;
}

.progress-bar {
  height: 10px;
  background: #333;
  border-radius: 5px;
  overflow: hidden;
  margin-bottom: 10px;
}

.progress-fill {
  height: 100%;
  background: linear-gradient(to right, #4facfe, #00f2fe);
  border-radius: 5px;
  transition: width 0.5s ease;
}

.progress-text {
  text-align: center;
  font-size: 0.9rem;
  color: #aaa;
}

.question-area {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.question-display {
  background: rgba(30, 30, 30, 0.8);
  border-radius: 15px;
  padding: 30px;
  border: 1px solid #333;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
  backdrop-filter: blur(5px);
  flex: 1;
}

.question-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 25px;
  padding-bottom: 15px;
  border-bottom: 1px solid #444;
}

.question-number {
  font-size: 1.6rem;
  font-weight: 700;
  color: #4facfe;
}

.question-status {
  padding: 6px 15px;
  border-radius: 20px;
  font-size: 0.9rem;
  font-weight: 600;
}

.answered {
  background: rgba(0, 176, 155, 0.2);
  color: #00b09b;
}

.unanswered {
  background: rgba(255, 100, 100, 0.2);
  color: #ff6464;
}

.question-text {
  font-size: 1.3rem;
  line-height: 1.6;
  margin-bottom: 30px;
  color: #e0e0e0;
}

.options-container {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.option-item {
  display: flex;
  align-items: center;
  padding: 18px 20px;
  border-radius: 12px;
  background: rgba(50, 50, 50, 0.7);
  border: 2px solid #444;
  cursor: pointer;
  transition: all 0.3s ease;
}

.option-item:hover {
  background: rgba(70, 70, 70, 0.7);
  transform: translateX(5px);
}

.selected {
  background: rgba(33, 147, 176, 0.2);
  border-color: #2193b0;
  box-shadow: 0 0 15px rgba(33, 147, 176, 0.3);
}

.correct {
  background: rgba(0, 176, 155, 0.2);
  border-color: #00b09b;
  box-shadow: 0 0 15px rgba(0, 176, 155, 0.3);
}

.option-letter {
  width: 36px;
  height: 36px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #444;
  border-radius: 50%;
  margin-right: 15px;
  font-weight: 700;
  font-size: 1.1rem;
}

.selected .option-letter, .correct .option-letter {
  background: linear-gradient(135deg, #2193b0, #6dd5ed);
  color: white;
}

.option-text {
  font-size: 1.1rem;
  line-height: 1.5;
}

.question-navigation {
  display: flex;
  justify-content: space-between;
  gap: 15px;
}

.nav-button, .submit-button {
  padding: 14px 30px;
  border: none;
  border-radius: 50px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.prev-button {
  background: linear-gradient(to right, #8e2de2, #4a00e0);
  color: white;
}

.next-button {
  background: linear-gradient(to right, #00c6ff, #0072ff);
  color: white;
  margin-left: auto;
}

.submit-button {
  background: linear-gradient(to right, #00b09b, #96c93d);
  color: white;
  margin-left: 10px;
}

.nav-button:hover, .submit-button:hover {
  transform: translateY(-3px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}

.nav-button:disabled, .submit-button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
  transform: none;
  box-shadow: none;
}

.notification {
  position: fixed;
  bottom: 30px;
  left: 50%;
  transform: translateX(-50%);
  padding: 15px 30px;
  border-radius: 50px;
  font-weight: 600;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
  z-index: 1000;
  animation: fadeInOut 3s forwards;
}

@keyframes fadeInOut {
  0% { opacity: 0; bottom: 0; }
  10% { opacity: 1; bottom: 30px; }
  90% { opacity: 1; bottom: 30px; }
  100% { opacity: 0; bottom: 0; }
}

.success {
  background: linear-gradient(to right, #00b09b, #96c93d);
  color: white;
}

.info {
  background: linear-gradient(to right, #4a00e0, #8e2de2);
  color: white;
}

/* Responsive Design */
@media (max-width: 992px) {
  .quiz-content {
    flex-direction: column;
  }
  
  .overview-panel {
    flex: 0 0 auto;
  }
  
  .question-grid {
    grid-template-columns: repeat(10, 1fr);
    overflow-x: auto;
    padding: 10px 0;
  }
  
  .question-card {
    min-width: 45px;
  }
}

@media (max-width: 768px) {
  .quiz-navbar {
    padding: 15px;
  }
  
  .quiz-title {
    font-size: 1.5rem;
  }
  
  .back-button {
    padding: 8px 15px;
    font-size: 0.9rem;
  }
  
  .question-display {
    padding: 20px;
  }
  
  .question-text {
    font-size: 1.1rem;
  }
  
  .option-text {
    font-size: 1rem;
  }
  
  .question-navigation {
    flex-wrap: wrap;
  }
  
  .nav-button, .submit-button {
    padding: 12px 20px;
    font-size: 0.9rem;
    flex: 1;
    min-width: 120px;
  }
  
  .question-grid {
    grid-template-columns: repeat(5, 1fr);
  }
}

@media (max-width: 480px) {
  .quiz-content {
    padding: 15px;
  }
  
  .overview-panel {
    padding: 15px;
  }
  
  .question-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
  }
  
  .question-status {
    align-self: flex-start;
  }
  
  .question-grid {
    grid-template-columns: repeat(5, 1fr);
    gap: 8px;
  }
  
  .question-card {
    font-size: 1rem;
  }
  
  .option-item {
    padding: 14px;
  }
  
  .option-letter {
    width: 30px;
    height: 30px;
    margin-right: 12px;
  }
}
</style>