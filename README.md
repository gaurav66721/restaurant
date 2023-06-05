<h1>Restaurant Table Booking Project</h1>

<p>
  This project is a web application for managing table reservations at a restaurant. It allows customers to view available tables, make reservations, and manage their bookings. The application is built using modern web technologies and follows the client-server architecture.
</p>

<h2>Features</h2>

<ul>
  <li><strong>User Registration and Authentication:</strong> Customers can create an account and log in to the system. This allows them to make reservations and manage their bookings.</li>
  <li><strong>Table Availability:</strong> The application provides a real-time view of table availability. Customers can see which tables are available for booking at a specific date and time.</li>
  <li><strong>Table Booking:</strong> Customers can select a table, provide the booking details (date, time, number of guests), and reserve it. The system ensures that the table is available for the specified time and updates the availability accordingly.</li>
  <li><strong>Booking Management:</strong> Customers can view and manage their existing bookings. They can cancel or modify their reservations based on the restaurant's policies.</li>
</ul>

<h2>Technologies Used</h2>

<ul>
  <li><strong>Frontend:</strong> The frontend of the application is built using HTML, CSS, and JavaScript.</li>
  <li><strong>Backend:</strong> The backend is developed using a server-side language Php (Symfony Framework). It handles user authentication, table availability, and booking management. The backend communicates with a database to store and retrieve data.</li>
  <li><strong>Database:</strong> The application uses a relational database management system (RDBMS) MySQL store data related to users, tables, and bookings.</li>
</ul>

<h2>Installation and Setup</h2>

<p>
  To run this project locally, follow these steps:
</p>

<ol>
  <li>Clone the repository:
    <code>git clone https://github.com/gaurav66721/restaurant.git</code>
  </li>
  <li>
    setup your database credential details in .env then run following command one by one.
    <pre>
       <code>composer install</code>
       <code>bin/console doctrine:database:create</code>
       <code>bin/console doctrine:migration:migrate</code>
       <code>npm install</code>
       <code>npm run dev</code>
    </pre>
  </li>
</ol>

<h2>Contributing</h2>

<p>Contributions are welcome! If you'd like to contribute to this project, please follow these guidelines:</p>

<ol>
  <li>Fork the repository and create a new branch for your feature or bug fix.</li>
  <li>Implement your changes, following the project's coding style and best practices.</li>
  <li>Write tests to ensure your code is functioning correctly.</li>
  <li>Commit your changes and push them to your fork.</li>
  <li>Submit a pull request, providing a detailed description of your changes.</li>
</ol>

<h2>License</h2>
<p>This project is licensed under the MIT License. Feel free to use, modify, and distribute the code as per the license terms.
</p>

<h2>Contact</h2>
<p>
  For any questions or inquiries, please contact the project maintainers:
</p>
<ul>
  <li>Gaurav Patel: mrgaurav66721@gmail.com</li>
</ul>
