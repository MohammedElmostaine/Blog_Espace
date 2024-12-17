const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    menuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });


    const toggleButton = document.querySelectorAll('.toggle-form');
    const registrationForm = document.querySelector('.inscription');
    const loginForm = document.querySelector('.connexion');
  
    toggleButton.forEach((btn)=>{
        btn.addEventListener('click', () => {
      
      registrationForm.classList.toggle('hidden');
      loginForm.classList.toggle('hidden');
  
      
    })});