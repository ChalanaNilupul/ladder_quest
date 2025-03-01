// firebase-config.js
import { initializeApp } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-app.js";
import { getAuth } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-auth.js";

// Firebase Configuration
const firebaseConfig = {
    apiKey: "AIzaSyABg2UIa30OtiwQeEcR9bGq1eJXHgZtrjQ",
    authDomain: "ladder-quest.firebaseapp.com",
    projectId: "ladder-quest",
    storageBucket: "ladder-quest.firebasestorage.app",
    messagingSenderId: "300591395574",
    appId: "1:300591395574:web:aed8eccf62500e50a8b2d7",
    measurementId: "G-YQB7N1R3F3"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);

// Export auth so other files can use it
export { auth };
