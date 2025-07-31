<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - AUNTY CO'S KITCHEN</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #fafafa;
        }

        /* Main Content */
        main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 90px 30px;
        }

        .gallery-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .gallery-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            color: #d4a574;
            margin-bottom: 15px;
        }

        .gallery-header p {
            font-size: 1.1rem;
            color: #666;
            max-width: 700px;
            margin: 0 auto 20px;
        }

        /* Special Info Banner */
        .special-info {
            background: linear-gradient(135deg, #fff3e0, #f5f5f5);
            border-left: 5px solid #d4a574;
            padding: 25px 30px;
            margin-bottom: 40px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .special-info h3 {
            font-family: 'Playfair Display', serif;
            color: #d4a574;
            font-size: 1.3rem;
            margin-bottom: 10px;
        }

        .special-info p {
            color: #555;
            margin-bottom: 8px;
        }

        .special-info .highlight {
            font-weight: 600;
            color: #d4a574;
        }

        /* Categories */
        .gallery-categories {
            text-align: center;
            margin-bottom: 40px;
        }

        .category-btn {
            background: white;
            border: 2px solid #d4a574;
            color: #d4a574;
            padding: 12px 30px;
            margin: 8px;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 1rem;
        }

        .category-btn:hover,
        .category-btn.active {
            background: #d4a574;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(212, 165, 116, 0.3);
        }

        /* Gallery Grid */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .gallery-item {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            background: white;
            cursor: pointer;
        }

        .gallery-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }

        .gallery-item img {
            width: 100%;
            height: 280px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.05);
        }

        .gallery-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            color: white;
            padding: 40px 25px 25px;
            transform: translateY(100%);
            transition: transform 0.3s ease;
        }

        .gallery-item:hover .gallery-caption {
            transform: translateY(0);
        }

        .gallery-caption h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            margin-bottom: 8px;
        }

        .gallery-caption p {
            font-size: 0.95rem;
            opacity: 0.9;
            line-height: 1.4;
        }

        /* Category badges */
        .category-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(212, 165, 116, 0.9);
            color: white;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            main {
                padding: 60px 20px;
            }

            .gallery-header h1 {
                font-size: 2rem;
            }

            .gallery-grid {
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 25px;
            }

            .gallery-item img {
                height: 220px;
            }

            .category-btn {
                padding: 10px 20px;
                margin: 5px;
                font-size: 0.9rem;
            }

            .special-info {
                padding: 20px;
                margin: 0 10px 30px;
            }
        }

        @media (max-width: 480px) {
            main {
                padding: 40px 15px;
            }

            .gallery-grid {
                grid-template-columns: 1fr;
            }

            .gallery-categories {
                margin-bottom: 30px;
            }

            .category-btn {
                display: block;
                width: 100%;
                margin: 8px 0;
            }
        }
    </style>
</head>
<body>
      <?php include 'header.php'; ?>

    <main>
        <div class="gallery-header">
            <h1>Our Culinary Gallery</h1>
            <p>Discover our three special daily meals and exceptional catering services for your memorable occasions</p>
        </div>

        <div class="special-info">
            <h3><i class="fas fa-star"></i> What Makes Us Special</h3>
            <p><span class="highlight">3 Special Meals Daily:</span> We craft three unique, special meals each day using the freshest ingredients</p>
            <p><span class="highlight">Event Catering:</span> Perfect for parties, birthdays, anniversaries, and special celebrations</p>
            <p><span class="highlight">Custom Menus:</span> Tailored dining experiences for your special occasions</p>
        </div>

        <div class="gallery-categories">
            <button class="category-btn active" data-category="all">All Dishes</button>
            <button class="category-btn" data-category="daily-specials">Daily Specials</button>
            <button class="category-btn" data-category="party-catering">Party Catering</button>
            <button class="category-btn" data-category="celebration">Celebrations</button>
            <button class="category-btn" data-category="drinks">Beverages</button>
            <button class="category-btn" data-category="restaurant">Our Space</button>
        </div>

        <div class="gallery-grid" id="galleryGrid">
            <!-- Daily Specials -->
            <div class="gallery-item" data-category="daily-specials">
                <div class="category-badge">Daily Special</div>
                <img src="images/eru.jpg" alt="waterfufu and eru">
                <div class="gallery-caption">
                    <h3>Waterfufu & Eru</h3>
                    <p>A flavorful Cameroonian classic made with finely shredded eru leaves, waterleaf, crayfish, smoked meat, and palm oil — served with soft waterfufu for a rich and satisfying experience.</p>
                </div>
            </div>

            <div class="gallery-item" data-category="daily-specials">
                <div class="category-badge">Daily Special</div>
                <img src="images/eru.jpg" alt="waterfufu and eru">
                <div class="gallery-caption">
                    <h3>Fried Rice & Chicken</h3>
                    <p>Deliciously spiced Cameroonian-style fried rice served with well-marinated grilled or fried chicken — a flavorful favorite for any occasion.</p>
                </div>
            </div>

            <div class="gallery-item" data-category="daily-specials">
                <div class="category-badge">Daily Special</div>
                 <img src="images/eru.jpg" alt="waterfufu and eru">
                <div class="gallery-caption">
                    <h3>Signature Jollof Rice</h3>
                    <p>Our special recipe jollof rice with tender chicken and fresh vegetables</p>
                </div>
            </div>

            <!-- Party Catering -->
            <div class="gallery-item" data-category="party-catering">
                <div class="category-badge">Catering</div>
                <img src="images/eru.jpg" alt="waterfufu and eru">
                <div class="gallery-caption">
                    <h3>Grand Party Platter</h3>
                    <p>Perfect for large gatherings - an assortment of our best dishes for 20+ guests</p>
                </div>
            </div>

            <div class="gallery-item" data-category="party-catering">
                <div class="category-badge">Catering</div>
                 <img src="images/eru.jpg" alt="waterfufu and eru">
                <div class="gallery-caption">
                    <h3>Buffet Catering</h3>
                    <p>Full buffet setup for corporate events, weddings, and large celebrations</p>
                </div>
            </div>

            <!-- Celebration Specials -->
            <div class="gallery-item" data-category="celebration">
                <div class="category-badge">Celebration</div>
                <img src="images/eru.jpg" alt="waterfufu and eru">
                <div class="gallery-caption">
                    <h3>Birthday Celebrations</h3>
                    <p>Custom birthday cakes and special celebration meals for your special day</p>
                </div>
            </div>

            <div class="gallery-item" data-category="celebration">
                <div class="category-badge">Celebration</div>
               <img src="images/eru.jpg" alt="waterfufu and eru">
                <div class="gallery-caption">
                    <h3>Anniversary Dinners</h3>
                    <p>Romantic anniversary packages with candlelit dinners and special decorations</p>
                </div>
            </div>

            <!-- Beverages -->
            <div class="gallery-item" data-category="drinks">
                <div class="category-badge">Beverages</div>
                <img src="images/eru.jpg" alt="waterfufu and eru">
                <div class="gallery-caption">
                    <h3>Fresh Tropical Juices</h3>
                    <p>Freshly squeezed mango, pineapple, and passion fruit juices</p>
                </div>
            </div>

            <div class="gallery-item" data-category="drinks">
                <div class="category-badge">Beverages</div>
                 <img src="images/eru.jpg" alt="waterfufu and eru">
                <div class="gallery-caption">
                    <h3>Premium Coffee</h3>
                    <p>Locally sourced Cameroon coffee beans, expertly roasted and brewed</p>
                </div>
            </div>

            <!-- Restaurant Space -->
            <div class="gallery-item" data-category="restaurant">
                <div class="category-badge">Our Space</div>
                <img src="images/eru.jpg" alt="waterfufu and eru">
                <div class="gallery-caption">
                    <h3>Elegant Dining Area</h3>
                    <p>Comfortable and elegant dining space perfect for intimate meals and celebrations</p>
                </div>
            </div>

            <div class="gallery-item" data-category="restaurant">
                <div class="category-badge">Our Space</div>
                 <img src="images/eru.jpg" alt="waterfufu and eru">
                <div class="gallery-caption">
                    <h3>Our Professional Kitchen</h3>
                    <p>State-of-the-art kitchen where our daily specials and catering orders come to life</p>
                </div>
            </div>

            <div class="gallery-item" data-category="restaurant">
                <div class="category-badge">Our Space</div>
               <img src="images/eru.jpg" alt="waterfufu and eru">
                <div class="gallery-caption">
                    <h3>Private Event Space</h3>
                    <p>Dedicated space for birthday parties, anniversaries, and special celebrations</p>
                </div>
            </div>
        </div>
    </main>

    
    <?php include 'footer.php'; ?>

    <script>
        // Gallery filtering functionality
        const categoryBtns = document.querySelectorAll('.category-btn');
        const galleryItems = document.querySelectorAll('.gallery-item');

        categoryBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Remove active class from all buttons
                categoryBtns.forEach(b => b.classList.remove('active'));
                // Add active class to clicked button
                btn.classList.add('active');

                const category = btn.dataset.category;

                // Filter gallery items
                galleryItems.forEach(item => {
                    if (category === 'all' || item.dataset.category === category) {
                        item.style.display = 'block';
                        setTimeout(() => {
                            item.style.opacity = '1';
                            item.style.transform = 'scale(1)';
                        }, 100);
                    } else {
                        item.style.opacity = '0';
                        item.style.transform = 'scale(0.8)';
                        setTimeout(() => {
                            item.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });

        // Initialize gallery items with smooth entrance
        window.addEventListener('load', () => {
            galleryItems.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateY(30px)';
                setTimeout(() => {
                    item.style.transition = 'all 0.6s ease';
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>