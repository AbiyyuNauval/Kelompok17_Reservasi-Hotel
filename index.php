<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Hotel Kami</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: #f2f4f8;
            color: #333;
            scroll-behavior: smooth;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(45deg, #4e54c8, #8f94fb);
            color: white;
            padding: 15px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar .logo {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
        }

        .navbar .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 25px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .navbar .nav-links a:hover {
            color: #e0e0e0;
            text-decoration: underline;
        }

        /* General Container & Section Title */
        .container {
            padding: 50px 5%;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 40px;
            color: #4e54c8;
        }

        .btn {
            background-color: #8f94fb;
            color: white;
            padding: 12px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #4e54c8;
        }
        
        /* Hero Section */
        .hero {
            background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('Gambar/Hotel.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
            padding: 120px 20px;
        }

        .hero h1 {
            font-size: 3rem;
            margin: 0;
            font-weight: 700;
        }

        .hero p {
            font-size: 1.2rem;
            margin-top: 10px;
            margin-bottom: 30px;
        }

        /* Base Card Grid - Untuk Services dan Testimoni */
        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        /* Services Section */
        #services {
             background-color: #ffffff;
        }
        
        .service-card {
            background: #f9faff;
            padding: 30px;
            text-align: center;
            border-radius: 12px;
            border: 1px solid #e0e7ff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .service-card:hover {
             transform: translateY(-10px);
             box-shadow: 0 8px 25px rgba(78, 84, 200, 0.1);
        }
        
        .service-card .icon {
            font-size: 3rem;
            color: #4e54c8;
            margin-bottom: 15px;
        }
        
        .service-card h3 {
            margin: 0;
            font-size: 1.2rem;
        }

        #rooms .card-grid-rooms {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
        }

        /* Rooms Section Card */
        .card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        .card img {
            width: 100%;
            height: 500px;
            object-fit: cover;
        }

        .card-content {
            padding: 20px;
            flex-grow: 1; /* Membuat konten mengisi ruang */
            display: flex;
            flex-direction: column;
        }

        .card h3 {
            margin-top: 0;
            color: #4e54c8;
        }

        .card p {
            font-size: 0.9rem;
            line-height: 1.6;
            flex-grow: 1; /* Mendorong harga dan tombol ke bawah */
        }

        .card .price {
            font-size: 1.3rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
        }
        
        .card .price span {
            font-size: 0.9rem;
            font-weight: 400;
            color: #777;
        }

        .card a.btn-pesan {
            display: block;
            text-align: center;
            background-color: #4e54c8;
            color: white;
            padding: 10px;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 15px;
            font-weight: 500;
        }
         .card a.btn-pesan:hover {
            background: #3b409b;
        }

        /* Testimonials Section */
        .testimonial-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .testimonial-card blockquote {
            margin: 0;
            font-style: italic;
            color: #555;
            border-left: 4px solid #8f94fb;
            padding-left: 15px;
        }

        .testimonial-card .author {
            margin-top: 15px;
            font-weight: 600;
            color: #4e54c8;
            text-align: right;
        }

        /* Contact Section */
        #contact {
            background-color: #ffffff;
        }

        .contact-wrapper {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 40px;
            align-items: flex-start;
        }

        .contact-info p {
            margin-bottom: 15px;
            line-height: 1.7;
        }

        .contact-form .form-group {
            margin-bottom: 20px;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
        }

        .contact-form textarea {
            resize: vertical;
            min-height: 120px;
        }

        /* Footer */
        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body>

    <header class="navbar">
        <h2 class="logo">Hotel Kelompok 17</h2>
        <nav class="nav-links">
            <a href="#hero">Beranda</a>
            <a href="#services">Layanan</a>
            <a href="#rooms">Kamar</a>
            <a href="#contact">Kontak</a>
            
            <?php if (isset($_SESSION['id_user'])): ?>
                <a href="riwayat_reservasi.php">Reservasi Saya</a>
                <a href="logout.php" style="background-color: #e63946; padding: 8px 15px; border-radius: 5px;">Logout</a>
            <?php else: ?>
                <a href="login.php" style="background-color: rgba(255, 255, 255, 0.2); border: 1px solid white; padding: 8px 15px; border-radius: 5px;">Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <section class="hero" id="hero">
        <h1>Kenyamanan dan Kemewahan Menanti Anda</h1>
        <p>Nikmati pengalaman menginap tak terlupakan dengan fasilitas terbaik.</p>
        <a href="#rooms" class="btn">Lihat Pilihan Kamar</a>
    </section>

    <section id="services" class="container">
        <h2 class="section-title">Layanan Terbaik Kami</h2>
        <div class="card-grid">
            <div class="service-card">
                <div class="icon">WIFI</div>
                <h3>WiFi Kecepatan Tinggi</h3>
                <p>Tetap terhubung dengan internet gratis di seluruh area hotel.</p>
            </div>
            <div class="service-card">
                <div class="icon">🍴</div>
                <h3>Restoran 24 Jam</h3>
                <p>Sajian lezat tersedia kapan pun Anda inginkan, pagi hingga malam.</p>
            </div>
            <div class="service-card">
                <div class="icon">🏊</div>
                <h3>Kolam Renang</h3>
                <p>Bersantai dan segarkan diri di kolam renang kami yang indah.</p>
            </div>
        </div>
    </section>

    <main class="container" id="rooms">
        <h2 class="section-title">Pilihan Kamar Kami</h2>
        <div class="card-grid-rooms"> <div class="card">
                <img src="Gambar/Single.jpg" alt="Kamar Single">
                <div class="card-content">
                    <h3>Kamar Single</h3>
                    <p>Ideal untuk solo traveler, menawarkan kenyamanan maksimal dalam ruang yang efisien dan fungsional.</p>
                    <div class="price">Rp 150.000 <span>/ malam</span></div>
                    <a href="reservasi.php?tipe=Single" class="btn-pesan">Pesan Sekarang</a>
                </div>
            </div>

            <div class="card">
                <img src="Gambar/Double.jpg" alt="Kamar Double">
                <div class="card-content">
                    <h3>Kamar Double</h3>
                    <p>Dilengkapi dengan tempat tidur ukuran queen atau twin, cocok untuk pasangan atau teman perjalanan.</p>
                    <div class="price">Rp 350.000 <span>/ malam</span></div>
                    <a href="reservasi.php?tipe=Double" class="btn-pesan">Pesan Sekarang</a>
                </div>
            </div>

            <div class="card">
                <img src="Gambar/Deluxe.jpeg" alt="Kamar Deluxe">
                <div class="card-content">
                    <h3>Kamar Deluxe</h3>
                    <p>Lebih luas dengan pemandangan kota, dilengkapi area duduk dan fasilitas premium untuk kenyamanan ekstra.</p>
                    <div class="price">Rp 600.000 <span>/ malam</span></div>
                    <a href="reservasi.php?tipe=Deluxe" class="btn-pesan">Pesan Sekarang</a>
                </div>
            </div>

            <div class="card">
                <img src="Gambar/Suite.jpg" alt="Kamar Suite">
                <div class="card-content">
                    <h3>Kamar Suite</h3>
                    <p>Ruang termewah kami dengan ruang tamu terpisah, menawarkan kemewahan dan privasi terbaik.</p>
                    <div class="price">Rp 1.000.000 <span>/ malam</span></div>
                    <a href="reservasi.php?tipe=Suite" class="btn-pesan">Pesan Sekarang</a>
                </div>
            </div>
        </div>
    </main>

    <section id="testimonials" class="container">
        <h2 class="section-title">Apa Kata Tamu Kami</h2>
        <div class="card-grid">
            <div class="testimonial-card">
                <blockquote>Pelayanannya luar biasa ramah dan kamarnya sangat bersih. Saya pasti akan kembali lagi!</blockquote>
                <p class="author">- Budi Santoso</p>
            </div>
            <div class="testimonial-card">
                <blockquote>Lokasi strategis dan fasilitasnya lengkap. Kolam renangnya menjadi favorit anak-anak saya. Sangat direkomendasikan.</blockquote>
                <p class="author">- Citra Lestari</p>
            </div>
            <div class="testimonial-card">
                <blockquote>Pengalaman menginap yang menyenangkan untuk perjalanan bisnis. WiFi kencang dan sarapannya enak.</blockquote>
                <p class="author">- David Lee</p>
            </div>
        </div>
    </section>

    <section id="contact" class="container">
        <h2 class="section-title">Hubungi Kami</h2>
        <div class="contact-wrapper">
            <div class="contact-info">
                <h3>Informasi Kontak</h3>
                <p><strong>Alamat:</strong><br>Jl. Jenderal Sudirman No. 77, Pekanbaru, Riau, Indonesia</p>
                <p><strong>Telepon:</strong><br>(0761) 123-4567</p>
                <p><strong>Email:</strong><br>info@HotelKelompok17.com</p>
            </div>
            <form class="contact-form" action="kirim_pesan.php" method="POST">
                <h3>Kirim Pesan</h3>
                <div class="form-group">
                    <input type="text" name="name" placeholder="Nama Anda" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email Anda" required>
                </div>
                <div class="form-group">
                    <textarea name="message" placeholder="Pesan Anda" required></textarea>
                </div>
                <button type="submit" class="btn">Kirim</button>
            </form>
        </div>
    </section>
    
    <footer class="footer">
        <p>&copy; 2025 Hotel Kelompok 17. Seluruh Hak Cipta Dilindungi.</p>
    </footer>

</body>
</html>