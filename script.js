// Constants
const registrationForm = document.getElementById('registration-form');
const loader = document.querySelector('.loader');
const loaderContent = document.querySelector('.loader-content');
const loaderSpinner = document.querySelector('.loader-spinner');

// Disable form and show loader
function showLoader() {
  registrationForm.classList.add('form-submitting');
  loader.style.display = 'flex';
}

// Enable form and hide loader
function hideLoader() {
  registrationForm.classList.remove('form-submitting');
  loader.style.display = 'none';
}

// Send email with ticket details
function sendEmail(formData) {
  const ticketNumber = Math.floor(Math.random() * 1000000);
  const fullName = `${formData.get('first-name')} ${formData.get('last-name')}`;
  const venue = 'Teens Pray Church';
  const time = '7:00 PM';

  // Construct email message
  const message = `
    <h2>Thank you for registering!</h2>
    <p>Your registration was successful. Here are your ticket details:</p>
    <ul>
      <li>Name: ${fullName}</li>
      <li>Ticket Number: ${ticketNumber}</li>
      <li>Venue: ${venue}</li>
      <li>Time: ${time}</li>
    </ul>
  `;

  // Send email using email API or service
  // Code to send email is not provided as it varies depending on email provider or service
}

// Submit registration form
registrationForm.addEventListener('submit', function (event) {
  event.preventDefault();
  showLoader();

  // Get form data
  const formData = new FormData(registrationForm);

  // Send form data to server
  // Code to send form data to server is not provided as it varies depending on backend technology and architecture

  // Simulate server delay for demo purposes
  setTimeout(() => {
    // Hide loader and enable form
    hideLoader();

    // Send email with ticket details
    sendEmail(formData);

    // Show success message
    alert('Registration successful. Check your email for your ticket details.');
  }, 3000); // Simulate 3 second delay
});
