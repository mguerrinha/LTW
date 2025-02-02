-- SQLite
INSERT INTO User (userName, name, surname, password, email, phoneNumber, address, isAdmin) VALUES("admin","admin", "admin", "$2y$10$Jnf9HP2B5O61WAu2K2rPoe7rkCH2mIJ4/2g/nwUfx2geagNM03RpG","admin@admin.com", 912345678, "Hidden", 1);
INSERT INTO User (userName, name, surname, password, email, phoneNumber, address, isAdmin) VALUES("ruicruz16","Rui", "Cruz", "$2y$10$Jnf9HP2B5O61WAu2K2rPoe7rkCH2mIJ4/2g/nwUfx2geagNM03RpG","rpsc16@gmail.com", 910000000, "Porto", 0);
INSERT INTO User (userName, name, surname, password, email, phoneNumber, address, isAdmin) VALUES("jao20","João", "Reis", "$2y$10$q6rWuZw4Go.633qyyh06eOhb6kcCyyHYeZoO6.lrBmSDGIQMG/7e.","joao2000@gmail.com", 910000000, "Porto", 0);
INSERT INTO User (userName, name, surname, password, email, phoneNumber, address, isAdmin) VALUES("mike04","Miguel", "Guerrinha", "$2y$10$6orfHQpTTLQhp38i3W2d8OAT3GJ0ztI0gUfdL1GQJDxdCAWbr8xRC","mlguerrinha@gmail.com", 910000000, "Gouveia", 0);


INSERT INTO PRODUCT (userId, name, description, price, size, model, brand, state, imagePath, isSold) VALUES(4, "T-shirt", "T-shirt de algodão", 10, 'S', 'T-shirt', 'Zara', 'Almost New', 'images/uploaded_images/t-shirt.jpg', 0);
INSERT INTO PRODUCT (userId, name, description, price, size, model, brand, state, imagePath, isSold) VALUES(3, "Calças", "Calças de ganga", 20, 'M', 'Calças', 'Levis', 'Used', 'images/uploaded_images/calcas.jpg', 0);
INSERT INTO PRODUCT (userId, name, description, price, size, model, brand, state, imagePath, isSold) VALUES(2, "Sapatilhas", "Sapatilhas de desporto", 30, '40', 'Sapatilhas', 'Nike', 'Bad State', 'images/uploaded_images/sapatilhas.jpg', 0);
INSERT INTO PRODUCT (userId, name, description, price, size, model, brand, state, imagePath, isSold) VALUES(2, "Camisa", "Camisa de lã", 40, 'L', 'Camisa', 'Pull&Bear', 'Almost New', 'images/uploaded_images/camisa1.jpg', 0);
INSERT INTO PRODUCT (userId, name, description, price, size, model, brand, state, imagePath, isSold) VALUES(3, "Camisa", "Camisa de Homem", 50, 'M', 'Camisa', 'Timberland', 'Used', 'images/uploaded_images/camisa2.jpg', 0);
INSERT INTO PRODUCT (userId, name, description, price, size, model, brand, state, imagePath, isSold) VALUES(3, "Colar", "Colar de ouro", 60, 'S', 'Colar', 'Blue Bird', 'Almost New', 'images/uploaded_images/colar.jpg', 0);
INSERT INTO PRODUCT (userId, name, description, price, size, model, brand, state, imagePath, isSold) VALUES(3, "Relógio", "Relógio de pulso", 70, 'M', 'Relógio', 'Swatch', 'Used', 'images/uploaded_images/relogio.jpg', 0);
INSERT INTO PRODUCT (userId, name, description, price, size, model, brand, state, imagePath, isSold) VALUES(4, "BookMac", "Computador muito rápido", 1000, '15inch', 'Pc', 'Air', 'Almost New', 'images/uploaded_images/macbook.jpg', 0);
INSERT INTO PRODUCT (userId, name, description, price, size, model, brand, state, imagePath, isSold) VALUES(2, "Candeeiro", "Candeeiro de mesa de cabeçeira", 45, '30cm', 'Candeeiro', 'IKEA', 'Used', 'images/uploaded_images/candeeiro.jpg', 0);
INSERT INTO PRODUCT (userId, name, description, price, size, model, brand, state, imagePath, isSold) VALUES(4, "Buzz Lightear", "Brinquedo do toy-story", 5, '15cm', 'Brinquedo', 'Disney', 'Bad State', 'images/uploaded_images/brinquedo.jpg', 0);
INSERT INTO PRODUCT (userId, name, description, price, size, model, brand, state, imagePath, isSold) VALUES(3, "Sofá", "Bom sofá confortável", 300, '1,20m', 'Extra large', 'Moviflor', 'Almost New', 'images/uploaded_images/sofa.jpg', 0);
INSERT INTO PRODUCT (userId, name, description, price, size, model, brand, state, imagePath, isSold) VALUES(4, "Cadeira", "Cadeira de escritório", 50, '50cm', 'Cadeira', 'IKEA', 'Used', 'images/uploaded_images/cadeira.jpg', 0);
INSERT INTO PRODUCT (userId, name, description, price, size, model, brand, state, imagePath, isSold) VALUES(2, "Máquina de café", "Máquina de café expresso", 100, '30cm', 'Café', 'Delta', 'Almost New', 'images/uploaded_images/cafe.jpg', 0);
INSERT INTO PRODUCT (userId, name, description, price, size, model, brand, state, imagePath, isSold) VALUES(3, "Astrolábio", "Astrolábio usado nas navegações de Luís Vaz de Camões", 20, '20cm', 'Astrolábio', 'Português', 'Used', 'images/uploaded_images/astrolabio.jpg', 0);
INSERT INTO PRODUCT (userId, name, description, price, size, model, brand, state, imagePath, isSold) VALUES(3, "Rimel", "Rimel de qualidade", 5, '5cm', 'Rimel', 'Maybelline', 'Almost New', 'images/uploaded_images/beleza.jpg', 0);
INSERT INTO PRODUCT (userId, name, description, price, size, model, brand, state, imagePath, isSold) VALUES(3, "Chuteira", "Chuteiras usadas pelo CR7", 90, '43', 'Mercurial', 'Nike', 'Used', 'images/uploaded_images/chuteira.jpg', 0);
INSERT INTO PRODUCT (userId, name, description, price, size, model, brand, state, imagePath, isSold) VALUES(3, "Bola", "Bola de futebol", 10, '30cm', 'Bola', 'Adidas', 'Almost New', 'images/uploaded_images/desporto.jpg', 0);
INSERT INTO PRODUCT (userId, name, description, price, size, model, brand, state, imagePath, isSold) VALUES(4, "Guitarra", "Guitarra Yamaha acústica", 130, '1m', 'Acústica', 'Yamaha', 'Almost New', 'images/uploaded_images/guitarra.jpg', 0);
INSERT INTO PRODUCT (userId, name, description, price, size, model, brand, state, imagePath, isSold) VALUES(2, "Vestido de Noiva", "Vestido de noiva em segunda mão usado uma vez", 350, 'S', 'Vestido de noiva', 'Aire Barcelona', 'Almost New', 'images/uploaded_images/vestido.jpg', 0);
INSERT INTO PRODUCT (userId, name, description, price, size, model, brand, state, imagePath, isSold) VALUES(4, "Monopólio", "Monopólio", 57, '50cm', 'Monopólio', 'Hasbro', 'Used', 'images/uploaded_images/monopolio.jpg', 0);


INSERT INTO ProductCategory (productId, categoryId) VALUES(1, 1);
INSERT INTO ProductCategory (productId, categoryId) VALUES(2, 1);
INSERT INTO ProductCategory (productId, categoryId) VALUES(3, 2);
INSERT INTO ProductCategory (productId, categoryId) VALUES(4, 1);
INSERT INTO ProductCategory (productId, categoryId) VALUES(5, 1);
INSERT INTO ProductCategory (productId, categoryId) VALUES(6, 3);
INSERT INTO ProductCategory (productId, categoryId) VALUES(7, 3);
INSERT INTO ProductCategory (productId, categoryId) VALUES(7, 4);
INSERT INTO ProductCategory (productId, categoryId) VALUES(8, 4);
INSERT INTO ProductCategory (productId, categoryId) VALUES(9, 5);
INSERT INTO ProductCategory (productId, categoryId) VALUES(10, 6);
INSERT INTO ProductCategory (productId, categoryId) VALUES(11, 5);
INSERT INTO ProductCategory (productId, categoryId) VALUES(11, 9);
INSERT INTO ProductCategory (productId, categoryId) VALUES(12, 5);
INSERT INTO ProductCategory (productId, categoryId) VALUES(12, 9);
INSERT INTO ProductCategory (productId, categoryId) VALUES(13, 5);
INSERT INTO ProductCategory (productId, categoryId) VALUES(13, 9);
INSERT INTO ProductCategory (productId, categoryId) VALUES(13, 4);
INSERT INTO ProductCategory (productId, categoryId) VALUES(14, 11);
INSERT INTO ProductCategory (productId, categoryId) VALUES(15, 10);
INSERT INTO ProductCategory (productId, categoryId) VALUES(16, 8);
INSERT INTO ProductCategory (productId, categoryId) VALUES(16, 2);
INSERT INTO ProductCategory (productId, categoryId) VALUES(17, 8);
INSERT INTO ProductCategory (productId, categoryId) VALUES(17, 6);
INSERT INTO ProductCategory (productId, categoryId) VALUES(18, 9);
INSERT INTO ProductCategory (productId, categoryId) VALUES(18, 12);
INSERT INTO ProductCategory (productId, categoryId) VALUES(19, 1);
INSERT INTO ProductCategory (productId, categoryId) VALUES(20, 7);
INSERT INTO ProductCategory (productId, categoryId) VALUES(20, 5);
INSERT INTO ProductCategory (productId, categoryId) VALUES(20, 9);
INSERT INTO ProductCategory (productId, categoryId) VALUES(20, 12);


INSERT INTO Category (name) VALUES("Roupa");        --1
INSERT INTO Category (name) VALUES("Calçado");      --2
INSERT INTO Category (name) VALUES("Acessórios");   --3
INSERT INTO Category (name) VALUES("Tecnologia");   --4
INSERT INTO Category (name) VALUES("Decoração");    --5
INSERT INTO Category (name) VALUES("Brinquedos");   --6
INSERT INTO Category (name) VALUES("Jogos");        --7
INSERT INTO Category (name) VALUES("Desporto");     --8
INSERT INTO Category (name) VALUES("Casa");         --9
INSERT INTO Category (name) VALUES("Beleza");       --10
INSERT INTO Category (name) VALUES("Antiguidades"); --11
INSERT INTO Category (name) VALUES("Diversos");     --12
