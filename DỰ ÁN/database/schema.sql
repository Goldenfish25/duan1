CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user','admin') DEFAULT 'user',
    phone VARCHAR(30) NULL,
    address VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    slug VARCHAR(120) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE foods (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(120) NOT NULL,
    slug VARCHAR(120) NOT NULL UNIQUE,
    description TEXT,
    price DECIMAL(12,2) NOT NULL,
    thumbnail VARCHAR(255) DEFAULT '/images/placeholder.jpg',
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(12,2) NOT NULL,
    status ENUM('pending','processing','completed','cancelled') DEFAULT 'pending',
    delivery_address TEXT NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    food_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (food_id) REFERENCES foods(id)
);

CREATE TABLE password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(120) NOT NULL,
    token VARCHAR(255) NOT NULL,
    expires_at DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (name, email, password, role)
VALUES ('Quản trị', 'admin@foodly.local', '$2y$10$k9PB/0ZlK1iD7agQkN7ye.rsQmRdXFSavwoMvVJE9idhraNangNh6', 'admin');

INSERT INTO categories (name, slug) VALUES
('Món chính', 'mon-chinh'),
('Đồ uống', 'do-uong'),
('Tráng miệng', 'trang-mieng');

INSERT INTO foods (category_id, name, slug, description, price, thumbnail) VALUES
(1, 'Cơm gà Hội An', 'com-ga-hoi-an', 'Cơm gà xé sợi với nước mắm gừng', 55000, 'https://images.unsplash.com/photo-1608039829574-3c2d1c9d5d0b'),
(1, 'Bún bò Huế', 'bun-bo-hue', 'Đậm đà đúng chuẩn Huế', 49000, 'https://images.unsplash.com/photo-1541698444083-023c97d3f4b6'),
(2, 'Trà đào cam sả', 'tra-dao-cam-sa', 'Giải nhiệt mùa hè', 39000, 'https://images.unsplash.com/photo-1497534446932-c925b458314e');

