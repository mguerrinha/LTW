DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS Product;
DROP TABLE IF EXISTS Purchase;
DROP TABLE IF EXISTS ProductCategory;
DROP TABLE IF EXISTS WishList;
DROP TABLE IF EXISTS ShoppingList;
DROP TABLE IF EXISTS Comment;


CREATE TABLE User (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    userName TEXT NOT NULL,
    name TEXT,
    surname TEXT,
    password TEXT NOT NULL,
    email TEXT NOT NULL,
    phoneNumber INTEGER (9),
    address TEXT,
    isAdmin INTEGER DEFAULT 0
);


CREATE TABLE Category (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL
);


CREATE TABLE Product (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    userId INTEGER NOT NULL,
    publicationDate TEXT DEFAULT CURRENT_TIMESTAMP,
    name TEXT NOT NULL,
    description TEXT,
    brand TEXT,
    model TEXT,
    size TEXT,
    price REAL NOT NULL,
    state TEXT CHECK(state IN ('Almost New', 'Used', 'Bad State')),
    imagePath TEXT,
    isSold INTEGER DEFAULT 0,
    FOREIGN KEY (userId) REFERENCES User(id) ON DELETE CASCADE
);


CREATE TABLE ProductCategory (
    productId INTEGER NOT NULL,
    categoryId INTEGER NOT NULL,
    PRIMARY KEY (productId, categoryId),
    FOREIGN KEY (productId) REFERENCES Product(id) ON DELETE CASCADE,
    FOREIGN KEY (categoryId) REFERENCES Category(id) ON DELETE CASCADE
);


CREATE TABLE Purchase (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    productId INTEGER NOT NULL,
    buyerId INTEGER NOT NULL,
    transactionDate DATE DEFAULT CURRENT_TIMESTAMP,
    methodTransition TEXT,
    address TEXT,
    FOREIGN KEY (productId) REFERENCES Product(id),
    FOREIGN KEY (buyerId) REFERENCES User(id) ON DELETE CASCADE
);


CREATE TABLE WishList (
    buyerId INTEGER NOT NULL,
    productId INTEGER NOT NULL,
    PRIMARY KEY (buyerId, productId),
    FOREIGN KEY (buyerId) REFERENCES User(id) ON DELETE CASCADE,
    FOREIGN KEY (productId) REFERENCES Product(id) ON DELETE CASCADE
);


CREATE TABLE ShoppingList (
    buyerId INTEGER NOT NULL,
    productId INTEGER NOT NULL,
    PRIMARY KEY (buyerId, productId),
    FOREIGN KEY (buyerId) REFERENCES User(id) ON DELETE CASCADE,
    FOREIGN KEY (productId) REFERENCES Product(id) ON DELETE CASCADE
);


CREATE TABLE Comment (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    userId INTEGER NOT NULL,
    productId INTEGER NOT NULL,
    commentary TEXT NOT NULL,
    dateTime DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userId) REFERENCES User(id) ON DELETE CASCADE,
    FOREIGN KEY (productId) REFERENCES Product(id) ON DELETE CASCADE
);

