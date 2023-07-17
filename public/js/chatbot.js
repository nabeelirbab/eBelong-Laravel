
var $j = jQuery.noConflict();
const questions = {
            freelancer: [

                {
                    text: "Are you looking for jobs?",
                    options: [
                        { value: "yes", label: "Yes" },
                        { value: "no", label: "No" }
                    ]
                },
               {
			      text: "What skills you have",
			      dropdown: true, // Indicate that this question uses a dropdown
			      options: [
				    { value: "3d-design", label: "3D design" },
				    { value: "accounting", label: "Accounting" },
				    { value: "accounting-bookkeeping", label: "Accounting & Bookkeeping" },
				    { value: "admin", label: "Admin" },
				    { value: "administrative-assistance", label: "Administrative Assistance" },
				    { value: "adobe-illustrator", label: "Adobe Illustrator" },
				    { value: "adobe-indesign", label: "Adobe Indesign" },
				    { value: "adobe-photoshop", label: "Adobe Photoshop" },
				    { value: "adobe-premier-pro", label: "Adobe Premier Pro" },
				    { value: "amazon-virtual-assistant", label: "Amazon Virtual Assistant" },
				    { value: "amazon-virtual-assistant-ava", label: "Amazon Virtual Assistant (AVA)" },
				    { value: "amazon-web-services-aws", label: "Amazon Web Services (AWS)" },
				    { value: "android-development", label: "Android development" },
				    { value: "angularjs-development", label: "AngularJS development" },
				    { value: "animation", label: "Animation" },
				    { value: "apache", label: "Apache" },
				    { value: "artificial-intelligence", label: "Artificial Intelligence" },
				    { value: "asp-development", label: "ASP Development" },
				    { value: "autocad", label: "AutoCAD" },
				    { value: "automation-testing", label: "Automation Testing" },
				    { value: "business-stationery-design", label: "Business Stationery Design" },
				    { value: "cloud-computing", label: "Cloud Computing" },
				    { value: "coding", label: "Coding" },
				    { value: "computer-vision", label: "Computer Vision" },
				    { value: "consulting", label: "Consulting" },
				    { value: "content-writing", label: "Content Writing" },
				    { value: "copywriter", label: "Copywriter" },
				    { value: "creative-writer", label: "Creative Writer" },
				    { value: "css", label: "CSS" },
				    { value: "data-entry", label: "Data Entry" },
				    { value: "data-mining", label: "Data Mining" },
				    { value: "data-science", label: "Data Science" },
				    { value: "data-science-analysis", label: "Data Science & Analysis" },
				    { value: "data-visualization", label: "Data Visualization" },
				    { value: "deep-learning", label: "Deep Learning" },
				    { value: "desktop-applications", label: "Desktop Applications" },
				    { value: "digital-marketing", label: "Digital Marketing" },
				    { value: "digital-marketing-1", label: "Digital Marketing 1" },
				    { value: "diptrace", label: "Diptrace" },
				    { value: "django-framework", label: "Django Framework" },
				    { value: "dlib", label: "Dlib" },
				    { value: "docker", label: "Docker" },
				    { value: "e-commerce", label: "E-Commerce" },
				    { value: "electrical-engineer", label: "Electrical Engineer" },
				    { value: "english-proofreading", label: "English Proofreading" },
				    { value: "expressjs", label: "Express.Js" },
				    { value: "fast-ai", label: "Fast AI" },
				    { value: "fast-api", label: "Fast API" },
				    { value: "festo-fluidsim", label: "Festo Fluidsim" },
				    { value: "flask", label: "Flask" },
				    { value: "flyer-design", label: "Flyer Design" },
				    { value: "graphic-designing", label: "Graphic Designing" },
				    { value: "growth-hacking", label: "Growth Hacking" },
				    { value: "growth-marketing", label: "Growth Marketing" },
				    { value: "html-5", label: "HTML 5" },
				    { value: "ios-development", label: "iOS development" },
				    { value: "java-development", label: "Java development" },
				    { value: "java-script", label: "Java Script" },
				    { value: "jenkins", label: "Jenkins" },
				    { value: "lead-generation", label: "Lead Generation" },
				    { value: "linux", label: "Linux" },
				    { value: "machine-learning", label: "Machine Learning" },
				    { value: "magento-1", label: "Magento" },
				    { value: "matlab", label: "MATLAB" },
				    { value: "matlot-lib", label: "Matlot lib" },
				    { value: "mern-stack", label: "Mern Stack" },
				    { value: "microsoft", label: "Microsoft" },
				    { value: "microsoft-azure", label: "Microsoft Azure" },
				    { value: "microsoft-visual-studio-c", label: "Microsoft Visual Studio (C++)" },
				    { value: "mobile-app-development", label: "Mobile App Development" },
				    { value: "mongo-db", label: "Mongo DB" },
				    { value: "my-sql", label: "My SQL" },
				    { value: "nginx", label: "NGINX" },
				    { value: "node-js", label: "Node Js" },
				    { value: "numpi", label: "NumPi" },
				    { value: "open-cv", label: "Open CV" },
				    { value: "pandas", label: "Pandas" },
				    { value: "pcb-design", label: "PCB Design" },
				    { value: "php", label: "PHP" },
				    { value: "php-laravel-framework", label: "PHP Laravel Framework" },
				    { value: "poster-design", label: "Poster Design" },
				    { value: "project-management", label: "Project Management" },
				    { value: "proof-reading", label: "Proof Reading" },
				    { value: "proteus", label: "Proteus" },
				    { value: "python-1", label: "Python" },
				    { value: "qa", label: "QA" },
				    { value: "react-native", label: "React Native" },
				    { value: "reactjs", label: "React.Js" },
				    { value: "sales-force", label: "Sales Force" },
				    { value: "seo", label: "SEO" },
				    { value: "shopify-development", label: "Shopify Development" },
				    { value: "simulink", label: "Simulink" },
				    { value: "social-media-marketing", label: "Social Media Marketing" },
				    { value: "spreadsheets", label: "Spreadsheets" },
				    { value: "test", label: "TEST" },
				    { value: "tkinter", label: "Tkinter" },
				    { value: "translating", label: "Translating" },
				    { value: "unit-testing", label: "Unit Testing" },
				    { value: "unix", label: "Unix" },
				    { value: "user-experience-design", label: "User Experience Design" },
				    { value: "video-editing", label: "Video Editing" },
				    { value: "virtual-assistant", label: "Virtual Assistant" },
				    { value: "voice-talent", label: "Voice talent" },
				    { value: "web-applications", label: "Web Applications" },
				    { value: "website-design", label: "Website Design" },
				    { value: "wikipedia-contributor", label: "Wikipedia Contributor" },
				    { value: "wordpress-development", label: "WordPress Development" },
				    { value: "wordpress-plugin-development", label: "Wordpress Plugin Development" },
				    { value: "wordpress-theme-development", label: "Wordpress Theme Development" },
				    { value: "zendesk", label: "Zendesk" }
				    // Add more options as needed
				]

			    },
            ],
            employer: [
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
			      dropdown: true, // Indicate that this question uses a dropdown
			      options: [
				    { value: "3d-design", label: "3D design" },
				    { value: "accounting", label: "Accounting" },
				    { value: "accounting-bookkeeping", label: "Accounting & Bookkeeping" },
				    { value: "admin", label: "Admin" },
				    { value: "administrative-assistance", label: "Administrative Assistance" },
				    { value: "adobe-illustrator", label: "Adobe Illustrator" },
				    { value: "adobe-indesign", label: "Adobe Indesign" },
				    { value: "adobe-photoshop", label: "Adobe Photoshop" },
				    { value: "adobe-premier-pro", label: "Adobe Premier Pro" },
				    { value: "amazon-virtual-assistant", label: "Amazon Virtual Assistant" },
				    { value: "amazon-virtual-assistant-ava", label: "Amazon Virtual Assistant (AVA)" },
				    { value: "amazon-web-services-aws", label: "Amazon Web Services (AWS)" },
				    { value: "android-development", label: "Android development" },
				    { value: "angularjs-development", label: "AngularJS development" },
				    { value: "animation", label: "Animation" },
				    { value: "apache", label: "Apache" },
				    { value: "artificial-intelligence", label: "Artificial Intelligence" },
				    { value: "asp-development", label: "ASP Development" },
				    { value: "autocad", label: "AutoCAD" },
				    { value: "automation-testing", label: "Automation Testing" },
				    { value: "business-stationery-design", label: "Business Stationery Design" },
				    { value: "cloud-computing", label: "Cloud Computing" },
				    { value: "coding", label: "Coding" },
				    { value: "computer-vision", label: "Computer Vision" },
				    { value: "consulting", label: "Consulting" },
				    { value: "content-writing", label: "Content Writing" },
				    { value: "copywriter", label: "Copywriter" },
				    { value: "creative-writer", label: "Creative Writer" },
				    { value: "css", label: "CSS" },
				    { value: "data-entry", label: "Data Entry" },
				    { value: "data-mining", label: "Data Mining" },
				    { value: "data-science", label: "Data Science" },
				    { value: "data-science-analysis", label: "Data Science & Analysis" },
				    { value: "data-visualization", label: "Data Visualization" },
				    { value: "deep-learning", label: "Deep Learning" },
				    { value: "desktop-applications", label: "Desktop Applications" },
				    { value: "digital-marketing", label: "Digital Marketing" },
				    { value: "digital-marketing-1", label: "Digital Marketing 1" },
				    { value: "diptrace", label: "Diptrace" },
				    { value: "django-framework", label: "Django Framework" },
				    { value: "dlib", label: "Dlib" },
				    { value: "docker", label: "Docker" },
				    { value: "e-commerce", label: "E-Commerce" },
				    { value: "electrical-engineer", label: "Electrical Engineer" },
				    { value: "english-proofreading", label: "English Proofreading" },
				    { value: "expressjs", label: "Express.Js" },
				    { value: "fast-ai", label: "Fast AI" },
				    { value: "fast-api", label: "Fast API" },
				    { value: "festo-fluidsim", label: "Festo Fluidsim" },
				    { value: "flask", label: "Flask" },
				    { value: "flyer-design", label: "Flyer Design" },
				    { value: "graphic-designing", label: "Graphic Designing" },
				    { value: "growth-hacking", label: "Growth Hacking" },
				    { value: "growth-marketing", label: "Growth Marketing" },
				    { value: "html-5", label: "HTML 5" },
				    { value: "ios-development", label: "iOS development" },
				    { value: "java-development", label: "Java development" },
				    { value: "java-script", label: "Java Script" },
				    { value: "jenkins", label: "Jenkins" },
				    { value: "lead-generation", label: "Lead Generation" },
				    { value: "linux", label: "Linux" },
				    { value: "machine-learning", label: "Machine Learning" },
				    { value: "magento-1", label: "Magento" },
				    { value: "matlab", label: "MATLAB" },
				    { value: "matlot-lib", label: "Matlot lib" },
				    { value: "mern-stack", label: "Mern Stack" },
				    { value: "microsoft", label: "Microsoft" },
				    { value: "microsoft-azure", label: "Microsoft Azure" },
				    { value: "microsoft-visual-studio-c", label: "Microsoft Visual Studio (C++)" },
				    { value: "mobile-app-development", label: "Mobile App Development" },
				    { value: "mongo-db", label: "Mongo DB" },
				    { value: "my-sql", label: "My SQL" },
				    { value: "nginx", label: "NGINX" },
				    { value: "node-js", label: "Node Js" },
				    { value: "numpi", label: "NumPi" },
				    { value: "open-cv", label: "Open CV" },
				    { value: "pandas", label: "Pandas" },
				    { value: "pcb-design", label: "PCB Design" },
				    { value: "php", label: "PHP" },
				    { value: "php-laravel-framework", label: "PHP Laravel Framework" },
				    { value: "poster-design", label: "Poster Design" },
				    { value: "project-management", label: "Project Management" },
				    { value: "proof-reading", label: "Proof Reading" },
				    { value: "proteus", label: "Proteus" },
				    { value: "python-1", label: "Python" },
				    { value: "qa", label: "QA" },
				    { value: "react-native", label: "React Native" },
				    { value: "reactjs", label: "React.Js" },
				    { value: "sales-force", label: "Sales Force" },
				    { value: "seo", label: "SEO" },
				    { value: "shopify-development", label: "Shopify Development" },
				    { value: "simulink", label: "Simulink" },
				    { value: "social-media-marketing", label: "Social Media Marketing" },
				    { value: "spreadsheets", label: "Spreadsheets" },
				    { value: "test", label: "TEST" },
				    { value: "tkinter", label: "Tkinter" },
				    { value: "translating", label: "Translating" },
				    { value: "unit-testing", label: "Unit Testing" },
				    { value: "unix", label: "Unix" },
				    { value: "user-experience-design", label: "User Experience Design" },
				    { value: "video-editing", label: "Video Editing" },
				    { value: "virtual-assistant", label: "Virtual Assistant" },
				    { value: "voice-talent", label: "Voice talent" },
				    { value: "web-applications", label: "Web Applications" },
				    { value: "website-design", label: "Website Design" },
				    { value: "wikipedia-contributor", label: "Wikipedia Contributor" },
				    { value: "wordpress-development", label: "WordPress Development" },
				    { value: "wordpress-plugin-development", label: "Wordpress Plugin Development" },
				    { value: "wordpress-theme-development", label: "Wordpress Theme Development" },
				    { value: "zendesk", label: "Zendesk" }
				    // Add more options as needed
				]

			    },
            ]
        };

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

		
        // chatContainer.appendChild(chatButton);

        function displayOptions(options) {
            const message = document.createElement('div');
            message.classList.add('message', 'bot-message');
            message.textContent = "You are";
            messagesContainer.appendChild(message);

            answerButtonsContainer.innerHTML = '';

            options.forEach(option => {
                const button = document.createElement('button');
                button.classList.add('btn','btn-success');
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
            const selectedQuestions = questions[selectedRole];

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
    const dropdown = document.createElement('select');
    dropdown.classList.add('answer-dropdown');
    chatContainer.style.height = '400px';
    dropdown.addEventListener('change', (event) => handleAnswer(question, event.target.value));

    question.options.forEach(option => {
      const optionElement = document.createElement('option');
      optionElement.value = option.value;
      optionElement.textContent = option.label;
      dropdown.appendChild(optionElement);
    });

    if (userAnswer) {
      dropdown.value = userAnswer;
    }

    answerButtonsContainer.appendChild(dropdown);

    // Initialize Select2 on the dropdown
  $j(dropdown).select2({
  placeholder: 'Select an option',
  allowClear: true
}).on('change', (event) => handleAnswer(question, event.target.value));

  } else {
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


function handleAnswer(question, answer) {
  const currentRole = userAnswers["role"];
  const currentQuestions = questions[currentRole];

  userAnswers[question.text] = answer;

  const answerMessage = document.createElement('div');
  answerMessage.classList.add('message', 'user-message');
  if(answer == 'no'){

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
		    chatContainer.style.height = 'auto';

		    // Reset the user answers and currentQuestionIndex
		    userAnswers = {};
		    currentQuestionIndex = 0;
		}
function callAPI() {
        	// alert('ddd');
			if(userAnswers['role'] == "freelancer"){
			   var skills = userAnswers['What skills you have'];
			     window.location.href = searchResultsUrl + '?type=job&' + encodeURIComponent('skills[]') + '=' + skills;

			}else{
				var skills = userAnswers['What are the key skills you are looking in your candidate'];
				  window.location.href = searchResultsUrl + '?type=freelancer&' + encodeURIComponent('skills[]') + '=' + skills;
			}

        }