<?php

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navbar with Burger Menu</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src = "\assets\js\script.js" defer></script>
</head>
<body class="bg-gray-100 text-gray-800">

  <!-- Navbar -->
  <nav class="bg-[#CCCCC4] text-white">
    <div class="container mx-auto flex justify-between items-center py-4 px-4">
      <!-- Logo -->
      <a href="index.html" class="text-2xl font-bold">Blog Espace</a>
      
      <!-- Burger Menu (Hidden on large screens) -->
      <button id="menu-btn" class="block md:hidden focus:outline-none">
        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
      
      <!-- Links (Hidden on small screens) -->
      <div id="menu" class="hidden md:flex space-x-6 flex items-center">
        <a href="index.html" class="hover:text-gray-200">Home</a>
        <?php
        
        if (isset($_SESSION['user_id'])) {
        echo'<a href="dashboard.html" class="hover:text-gray-200">Dashboard</a>';
        
        }
        ?>

        
        <a href="login.html" class="hover:text-gray-200">Login</a>
        <a href="register.html" class="hover:text-gray-200">Register</a>
        <button id="toggle-form" class="toggle-form bg-[#807F7B] text-white py-2 px-4 rounded hover:text-black hover:bg-[#FFFFED]">
    Register/Connexion
  </button>
      </div>
    </div>

    <!-- Mobile Menu (Hidden by default) -->
    <div id="mobile-menu" class="hidden bg-[#CCCCC4] md:hidden ">
      <a href="index.html" class="block px-4 py-2 hover:bg-white hover:text-black">Home</a>
      <a href="dashboard.html" class="block px-4 py-2 hover:bg-white hover:text-black">Dashboard</a>
      <a href="login.html" class="block px-4 py-2 hover:bg-white hover:text-black">Login</a>
      <a href="register.html" class="block px-4 py-2 hover:bg-white hover:text-black">Register</a>
      <button id="toggle-form" class="toggle-form bg-[#807F7B] text-white py-2 px-4 rounded hover:bg-[#FFFFED] mb-[5px] hover:text-black justify-selfe-center">
    Register/Connexion
  </button>
    </div>
  </nav>




    <section >
<!-- Formulaire d'inscription -->
<div class="inscription container mx-auto mt-10 flex justify-center">
<div class="w-full md:w-1/2">
  <h2 class="ml-[10px]  text-2xl font-bold mb-4">Inscription</h2>
  <form action="register.php" method="POST" class="bg-white p-6 rounded shadow-md w-full">
    <div class="mb-4">
      <label for="username" class="block text-gray-700">Nom d'utilisateur</label>
      <input type="text" id="username" name="username" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
    </div>
    <div class="mb-4">
      <label for="email" class="block text-gray-700">Email</label>
      <input type="email" id="email" name="email" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
    </div>
    <div class="mb-4">
      <label for="password" class="block text-gray-700">Mot de passe</label>
      <input type="password" id="password" name="password" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
    </div>
    <button type="submit" class="w-full bg-[#807F7B] text-white hover:text-black  py-2 rounded hover:bg-[#FFFFED]">S'inscrire</button>
  </form>
</div>
</div>


    </section>
  
    <section>
        <!-- Formulaire de connexion -->
<div class="connexion  container mx-auto mt-10 flex justify-center hidden">
  <div class="w-full md:w-1/2">
    <h2 class="ml-[10px]  text-2xl font-bold mb-4">Connexion</h2>
    <form action="login.php" method="POST" class="bg-white p-6 rounded shadow-md">
      <div class="mb-4">
        <label for="username" class="block text-gray-700">Nom d'utilisateur</label>
        <input type="text" id="username" name="username" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
      </div>
      <div class="mb-4">
        <label for="password" class="block text-gray-700">Mot de passe</label>
        <input type="password" id="password" name="password" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
      </div>
      <button type="submit" class="w-full bg-[#807F7B] text-white hover:text-black py-2 rounded hover:bg-[#FFFFED]">Se connecter</button>
    </form>
  </div>
</div>
    </section>

</body>
</html>
