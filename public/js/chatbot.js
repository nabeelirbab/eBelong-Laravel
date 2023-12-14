
var $j = jQuery.noConflict();
var freelancerQuestions = [
	{
		text: "Are you looking for jobs?",
		options: [
			{ value: "yes", label: "Yes" },
			{ value: "no", label: "No" }
		]
	},
	{
		text: "What skills do you have?",
		dropdown: true,
		options: allskills
	},
];

var employerQuestions = [
	{
		text: "Are you an employer?",
		options: [
			{ value: "yes", label: "Yes" },
			{ value: "no", label: "No" }
		]
	},
	{
		text: "Are you looking for freelancers?",
		options: [
			{ value: "yes", label: "Yes" },
			{ value: "no", label: "No" }
		]
	},
	{
		text: "What are the key skills you are looking in your candidate",
		dropdown: false, // Indicate that this question uses an input box
		// options: allskills
	},
];

let currentQuestionIndex = 0;
const messagesContainer = document.getElementById('messages-container');
const answerButtonsContainer = document.getElementById('answer-buttons-container');
const chatContainer = document.getElementById('chat-container');
let userAnswers = {};

const startupOptions = [
	{ value: "freelancer", label: "I'm a Freelancer" },
	{ value: "employer", label: "I'm hiring" }
];
let isChatActive = false;
const chatButton = document.getElementById('floating-button');

// Hide messagesContainer initially
chatContainer.style.display = 'none';

chatButton.addEventListener('click', () => {
	if (!isChatActive) {
		// Show chatContainer and display options
		chatContainer.style.display = 'block';
		displayOptions(startupOptions);
		isChatActive = true;
	} else {
		// Hide chatContainer and hide options
		chatContainer.style.display = 'none';
		hideOptions();
		isChatActive = false;
	}
});

function displayOptions(options) {
	const message = document.createElement('div');
	message.classList.add('message', 'bot-message');
	message.textContent = "You are";
	messagesContainer.appendChild(message);

	answerButtonsContainer.innerHTML = '';

	options.forEach(option => {
		const button = document.createElement('button');
		button.classList.add('btn', 'btn-success');
		button.textContent = option.label;
		button.value = option.value;
		button.addEventListener('click', () => handleOptionSelect(option.value));
		answerButtonsContainer.appendChild(button);
	});
}

function handleOptionSelect(option) {
	userAnswers["role"] = option;
	currentQuestionIndex = 0;
	messagesContainer.innerHTML = '';
	answerButtonsContainer.innerHTML = '';

	const selectedRole = userAnswers["role"];
	const selectedQuestions = selectedRole === "freelancer" ? freelancerQuestions : employerQuestions;

	displayQuestion(selectedQuestions[currentQuestionIndex]);
}

function displayQuestion(question) {
	const message = document.createElement('div');
	message.classList.add('message', 'bot-message');
	message.textContent = question.text;
	messagesContainer.appendChild(message);

	answerButtonsContainer.innerHTML = '';

	const userAnswer = userAnswers[question.text];

	if (question.dropdown) {
		// Dropdown handling
	} else {
		const inputContainer = document.getElementById('key-skills-input-container');
		const inputBox = document.getElementById('key-skills-input');
		const submitButton = document.getElementById('submit-key-skills');

		if (question.text === "What are the key skills you are looking in your candidate") {
			inputContainer.style.display = 'flex';

			// Handle the button click event
			submitButton.addEventListener('click', () => handleKeySkillsSubmit(question));
		} else {
			inputContainer.style.display = 'none';
		}
		if (question.options && Array.isArray(question.options)) {
			question.options.forEach(option => {
				const button = document.createElement('button');
				button.classList.add('answer-button');
				button.textContent = option.label;
				button.value = option.value;
				button.addEventListener('click', () => handleAnswer(question, option.value));

				if (userAnswer === option.value) {
					button.classList.add('selected');
				}

				answerButtonsContainer.appendChild(button);
			});
		}
	}
}

function handleAnswer(question, answer) {
	const currentRole = userAnswers["role"];
	const currentQuestions = currentRole === "freelancer" ? freelancerQuestions : employerQuestions;

	userAnswers[question.text] = answer;

	const answerMessage = document.createElement('div');
	answerMessage.classList.add('message', 'user-message');
	if (answer == 'no') {
		hideOptions();
		displayOptions(startupOptions);
		return false
	}
	answerMessage.textContent = `${answer}`;
	messagesContainer.appendChild(answerMessage);

	currentQuestionIndex++;

	if (currentQuestionIndex < currentQuestions.length) {
		displayQuestion(currentQuestions[currentQuestionIndex]);
	} else {
		callAPI(answer);
	}
}

function hideOptions() {
	// Clear the previous messages and answers
	messagesContainer.innerHTML = '';
	answerButtonsContainer.innerHTML = '';

	// Reset the user answers and currentQuestionIndex
	userAnswers = {};
	currentQuestionIndex = 0;
}

function handleKeySkillsSubmit(question) {
	const inputBox = document.getElementById('key-skills-input');
	const keySkills = inputBox.value;

	if (keySkills.trim() !== '') {
		const currentRole = userAnswers["role"];
		const currentQuestions = currentRole === "freelancer" ? freelancerQuestions : employerQuestions;

		userAnswers[question.text] = keySkills;

		const answerMessage = document.createElement('div');
		answerMessage.classList.add('message', 'user-message');
		answerMessage.textContent = `${keySkills}`;
		messagesContainer.appendChild(answerMessage);

		currentQuestionIndex++;

		if (currentQuestionIndex < currentQuestions.length) {
			displayQuestion(currentQuestions[currentQuestionIndex]);
		} else {
			callAPI(keySkills);
		}
	}
}

// function callAPI(answer) {
// 	// Replace this with your actual API call
// 	fetch('/chat', {
// 		method: 'POST',
// 		headers: {
// 			'Content-Type': 'application/json',
// 		},
// 		body: JSON.stringify({
// 			question: answer,
// 		}),
// 	})
// 		.then(response => response.json())
// 		.then(data => {
// 			// Display the API response in the chat
// 			const apiResponseMessage = document.createElement('div');
// 			apiResponseMessage.classList.add('message', 'bot-message');
// 			apiResponseMessage.textContent = data.message; // Replace 'message' with the actual property in your API response
// 			messagesContainer.appendChild(apiResponseMessage);
// 		})
// 		.catch(error => {
// 			console.error('Error:', error);
// 		});
// }

function callAPI(answer) {
	if (userAnswers['role'] == "freelancer") {
		var skills = userAnswers['What skills you have'];
		window.location.href = searchResultsUrl + '?type=job&' + encodeURIComponent('skills[]') + '=' + skills;

	} else {
		fetch('http://chatb-912710881.us-east-1.elb.amazonaws.com/chat', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
			},
			body: JSON.stringify({
				question: answer,
			}),
		})
			.then(response => response.json())
			.then(data => {
				console.log(data.answer); // Log the raw data.answer
				const apiResponseMessage = document.createElement('div');
				apiResponseMessage.classList.add('message', 'bot-message');
				apiResponseMessage.textContent = JSON.parse(data.answer).text; // Replace 'message' with the actual property in your API response
				messagesContainer.appendChild(apiResponseMessage);
			})
			.catch(error => {
				console.error('Error:', error);
			});

	}

}