<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Train of Thought - Blog Replica</title>
    
    <link rel="stylesheet" href="blog-style.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <header>
        <div class="top-bar">Kumpulan Game Jaringan Cerdas, Tugas matakuliah Jaringan Cerdas Multimedia.</div>
        <h1 class="site-title">Train of Thought</h1>
        
        <nav class="main-nav">
            <div class="nav-links">
                <a href="index.php?page=home" class="<?php echo (!isset($_GET['page']) || $_GET['page'] == 'home') ? 'active' : ''; ?>">Beranda</a>

                <a href="index.php?page=tictactoe" class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'tictactoe') ? 'active' : ''; ?>">Tic Tac Toe</a>

                <a href="index.php?page=guntingbatu" class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'guntingbatu') ? 'active' : ''; ?>">Gunting Batu Kertas</a>

                <a href="index.php?page=tebakkalimat" class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'tebakkalimat') ? 'active' : ''; ?>">Tebak Kalimat</a>

                <a href="index.php?page=tebakangkaai" class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'tebakangkaai') ? 'active' : ''; ?>">Tebak Angka AI</a>

                <a href="index.php?page=aitebakangka" class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'aitebakangka') ? 'active' : ''; ?>">AI Tebak Angka</a>
            </div>
            <div class="nav-icons">
                <a href="http://facebook.com/"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>
                <a href="http://twitter.com/"><i class="fab fa-twitter"></i></a>
            </div>
        </nav>
    </header>

    <section class="featured-post container">
    <?php
    $page = isset($_GET['page']) ? $_GET['page'] : 'home';

    if ($page == 'tictactoe') {
        
        echo '<div style="width: 100%; height: 650px; border: 1px solid #ddd; border-radius: 8px; overflow: hidden;">
                <iframe src="TicTacToe_AI/index.html" width="100%" height="100%" style="border:none;"></iframe>
              </div>';

    } elseif ($page == 'guntingbatu') {
         
        echo '<div style="width: 100%; height: 600px; border: 1px solid #ddd; border-radius: 8px; overflow: hidden;">
                <iframe src="GameSuit/index.php" width="100%" height="100%" style="border:none;"></iframe>
              </div>';

    } elseif ($page == 'tebakkalimat') {
        
        echo '<div style="width: 100%; height: 700px; border: 1px solid #ddd; border-radius: 8px; overflow: hidden;">
                <iframe src="tebakkalimat/index.php" width="100%" height="100%" style="border:none;"></iframe>
              </div>';
              
    } elseif ($page == 'tebakangkaai') {
        
        echo '<div style="width: 100%; height: 500px; border: 1px solid #ddd; border-radius: 8px; overflow: hidden;">
                <iframe src="GameMenebakAngkaAI/index.php" width="100%" height="100%" style="border:none;"></iframe>
              </div>';
    
    } elseif ($page == 'aitebakangka') {
        
        echo '<div style="width: 100%; height: 500px; border: 1px solid #ddd; border-radius: 8px; overflow: hidden;">
                <iframe src="GameAIMenebakAngka/index.html" width="100%" height="100%" style="border:none;"></iframe>
              </div>';

    } else {
        
    ?>
        <div class="featured-label">Statistik PC Anda</div>
        <div class="pc-stats-blending">
            
            <div class="stats-card">
                <h3 class="stats-title">Status Hardware PowerShell</h3>
                <div class="stats-content">
                    <?php include 'PCStats/pc_sendiri_2.php'; ?>
                </div>
            </div>

            <div class="stats-card">
                <h3 class="stats-title">Status Hardware Server</h3>
                <div class="stats-content">
                    <?php include 'PCStats/pc_sendiri.php'; ?>
                </div>
            </div>

        </div>
    <?php
    }
    ?>
    </section>

    <div class="container main-layout">
        
        <main class="blog-feed">
            <div class="feed-header">
                <h3>TRAIN OF THOUGHT</h3>
            </div>

            <article class="post-item">
                <img src="https://www.gamereactor.asia/media/20/clairobscure_4272083b.jpg" alt="Expedition_33">
                <div class="post-info">
                    <div class="meta">Dec 12, 2025 &bull; 1 min read</div>
                    <a href="https://rri.co.id/hiburan/2037753/clair-obscur-expedition-33-raih-goty-2025">
                        <h4>Clair Obscur: Expedition 33 Raih GOTY 2025</h4>
                    </a>
                    <p>KBRN, Jakarta: Ajang The Game Awards 2025 menetapkan 'Clair Obscur:Expedition 33' sebagai Game of the Year (GOTY)...</p>
                </div>
            </article>

            <article class="post-item">
                <img src="https://assets.aboutamazon.com/e0/b7/20a2997f4cd4b8769efd543b59e6/aa-dec2025-tombraider-v1-2000x1125.jpg" alt="Tomb_Raider">
                <div class="post-info">
                    <div class="meta">Dec 12, 2025 &bull; 1 min read</div>
                    <a href="https://www.theguardian.com/games/2025/dec/12/charismatic-self-assured-formidable-lara-croft-returns-with-two-new-tomb-raider-games">
                        <h4>Dua game Tomb Raider baru.</h4>
                    </a>
                    <p>Petualangan Croft yang benar-benar baru, Tomb Raider Catalyst, akan dirilis pada tahun 2027 – dan sebuah remake...</p>
                </div>
            </article>

            <article class="post-item">
                <img src="https://statik.tempo.co/data/2025/12/09/id_1446391/1446391_720.jpg" alt="Aceh">
                <div class="post-info">
                    <div class="meta">Dec 12, 2025 &bull; 1 min read</div>
                    <a href="https://www.tempo.co/ekonomi/pln-kebut-upaya-pemulihan-listrik-di-aceh-2098199">
                        <h4>PLN Kebut Upaya Pemulihan Listrik di Aceh</h4>
                    </a>
                    <p>PLN menyebut Saluran Udara Tegangan Tinggi Langsa-Pangkalan Brandan merupakan kunci untuk pemulihan sistem kelistrikan Aceh...</p>
                </div>
            </article>
        </main>

        <aside class="sidebar">
            <div class="widget about-widget">
                <h3>Tentang Website</h3>
                <p>Website ini dibuat untuk menampung semua tugas yang diberikan pada matakuliah Jaringan Cerdas Multimedia sebagai pengumpulan Tugas Muhammad Rafif Naufal - 2290343069 - RJ22B.</p>
            </div>

            <div class="widget pick-widget">
                <h3>Buku pilihan <br> di bulan ini</h3>
                <img src="https://cdn.prod.website-files.com/64ef5384b5c9feef638d15be/64fb3b16d40dc0f450a1de2a_thumbnail.jpg" alt="Book Cover">
                <img src="https://mir-s3-cdn-cf.behance.net/project_modules/max_1200_webp/43a5a3142216477.62627ec077ba5.png" alt="Book Cover">
            </div>
        </aside>
    </div>

    <footer class="contact-footer">
        <div class="copyright">
            &copy; 2035 Template by Wix - Train of Thoughts.
        </div>
    </footer>

</body>
</html>