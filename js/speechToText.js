const icon = document.getElementById('mic-icon');
const startButton = document.getElementById('mic-button');
const output = document.getElementById('engtext');

const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
const recognition = new SpeechRecognition();
recognition.continious=true;

recognition.onstart = () => {
    console.log('Speech recognition started. You can speak now.');
};
recognition.onend = () => {
    console.log('Speech recognition ended.');
    icon.classList.toggle('fa-microphone');
    icon.classList.toggle('fa-microphone-slash');
};

recognition.onresult = (event) => {
    const transcript = event.results[0][0].transcript;
    output.value = transcript;
};

recognition.onerror = (event) => {
    console.error('Speech recognition error:', event.error);
};

startButton.addEventListener('click', () => {
    icon.classList.toggle('fa-microphone');
    icon.classList.toggle('fa-microphone-slash');
    recognition.start();
});
