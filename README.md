# Velvet Vogue

### Project Title: Development of the Velvet Vogue E-Commerce Ecosystem
This project involves the design and implementation of a comprehensive multi-page web solution for "Velvet Vogue," a fashion startup owned by John Finlo. The primary objective was to transform a physical business vision into a high-performing digital brand.

By leveraging PHP and MySQL, we have developed a secure, responsive platform that caters to the needs of young adults. Key deliverables included a visually compelling product showcase, an intuitive category-based filtering system (Gender, Size, Price), and a robust user authentication framework. The system facilitates a complete "Purchase-to-Profile" journey, allowing customers to manage their own accounts while providing the administrator with a bespoke dashboard to handle inventory and business growth.

# Site Map Architecture & Navigation Flow

![Screenshot_2-1-2026_185428_gemini google com](https://github.com/user-attachments/assets/874d2a99-7872-4800-9978-f7aae1b71927)

### Velvet Vogue: Technical Challenges & Resolutions

**1. The "Headers Already Sent" Error (Redirect Failures)**

**The Challenge:** On pages like cart.php and account.php, the system would throw a PHP Warning when attempting to redirect unauthenticated users to the login page. This happened because HTML from header.php was being sent to the browser before the header("Location: ...") command was executed.

_The Solution:_ We restructured the page architecture to follow a "Logic-First" approach. We moved the session_start() and authentication checks to the absolute first lines of the PHP file, ensuring the server makes security decisions before a single byte of HTML is rendered.

**2. Silent Navigation Failures (Footer Redirects)**

**The Challenge:** When a guest user clicked "Track Order" in the footer, the page would stop loading after the header, showing a white screen. The script was dying during the redirect because of the output conflict mentioned above.

_The Solution:_ Beyond fixing the header order, we implemented Smart Routing. We updated footer links to include URL parameters (e.g., account.php?tab=orders). We then added a JavaScript "Tab Activator" that listens for these parameters and automatically opens the correct section for the user upon arrival.

**3. Dynamic Filtering Synchronization**

**The Challenge:** Ensuring that clicking "Women's Wear" in the footer or "Men" in the header accurately filtered the products on the shop.php page without creating separate files for every category.

_The Solution:_ We implemented a Centralized Query Engine in shop.php. By using $_GET['category'] parameters, we created a dynamic SQL builder that modifies the WHERE clause of the product query on the fly. This allowed one single file to serve infinite category combinations.

**4. Database Integrity for New Collections**

**The Challenge:** The client required a new "Accessories" category (ID 5) that didn't exist in the initial database schema, which risked breaking the navigation links.

_The Solution:_ We utilized SQL Constraints and ON DUPLICATE KEY UPDATE commands. This ensured that the category was safely injected into the database without duplicating records, providing a solid foundation for the new product line.

**5. Maintaining State in Tabbed Interfaces**

**The Challenge:** In the "My Account" area, users expected to switch between Order History and Wishlist without the page flickering or resetting to the top.

_The Solution:_ We built a CSS-JS Hybrid Tab System. Using Bootstrap-inspired classes and custom JavaScript, we managed the "Active" states of the tabs in the browser's memory, providing a smooth, app-like feel that mirrors modern luxury shopping platforms.

**6. Cart Count Synchronization**

**The Challenge:** Keeping the shopping bag icon in the header updated with the correct number of items as the user navigated between different directories and pages.

_The Solution:_ We integrated a Global Cart Listener inside header.php. Since the header is included on every page, we added a small SQL aggregate function (SUM(quantity)) that runs at the start of every page load, ensuring the user always sees their current total.

## Sign In

![Screenshot_2-1-2026_222436_localhost](https://github.com/user-attachments/assets/760608a6-35d5-4a19-be4b-f015eb2ec3d9)

## Create Account

![Screenshot_2-1-2026_222458_localhost](https://github.com/user-attachments/assets/c6ed4d4d-c6d8-4000-acc7-b9bb8739a428)

# CUSTOMER

## Homepage

![Screenshot_2-1-2026_221735_localhost](https://github.com/user-attachments/assets/7ae81528-0d24-465d-81a9-c166f5e7dbaa)

## The Collection

![Screenshot_2-1-2026_22203_localhost](https://github.com/user-attachments/assets/fd6dcd18-d298-4e82-be7b-92e107267aa5)

## Product Item

![Screenshot_2-1-2026_222051_localhost](https://github.com/user-attachments/assets/55c639d4-2028-4504-8832-4a7a8e7a16f3)

## Empty Shopping Cart

![Screenshot_2-1-2026_222131_localhost](https://github.com/user-attachments/assets/9370b556-7f90-4d5f-8e4b-5da3226cedbc)

## Add An Item

![Screenshot_2-1-2026_222145_localhost](https://github.com/user-attachments/assets/cb5f5e41-a266-4345-95a3-802721b5396b)

## Proceed To Checkout

![Screenshot_2-1-2026_22226_localhost](https://github.com/user-attachments/assets/ba7e7dc9-20bb-4aab-bdb5-c233303a50f2)

## Account Page (Without Adding A Purchase)

![Screenshot_2-1-2026_222229_localhost](https://github.com/user-attachments/assets/79b57a50-c778-494a-92db-652057f89fa8)

## Account Page (With Purchases Added)

![Screenshot_2-1-2026_222557_localhost](https://github.com/user-attachments/assets/b78e83e2-ad41-4043-8276-9fe9cbf0c261)

## Wishlist

![Screenshot_2-1-2026_222610_localhost](https://github.com/user-attachments/assets/504b42a3-685e-44af-842a-a21382d873a7)

## Wallet

![Screenshot_2-1-2026_222617_localhost](https://github.com/user-attachments/assets/8ce6e306-59a4-4b3f-b5ca-806fe0d3a00f)

## Settings

![Screenshot_2-1-2026_222625_localhost](https://github.com/user-attachments/assets/ed970fc5-4285-4428-aa84-91767332ee28)

## Customer Support & Inquiry

![Screenshot_2-1-2026_222246_localhost](https://github.com/user-attachments/assets/3b864fc5-e312-4079-bd69-aa79449a4c68)

# ADMIN

## Admin Dashboard

![Screenshot_2-1-2026_222313_localhost](https://github.com/user-attachments/assets/e1bae690-197f-4fe1-9f61-89f74a1e7539)

## Add To Collection 

![Screenshot_2-1-2026_222322_localhost](https://github.com/user-attachments/assets/7a2b5fd8-137d-48bf-9964-c8cfeaca4898)

## Update An Item

![Screenshot_2-1-2026_222334_localhost](https://github.com/user-attachments/assets/39a01b53-d55c-49b7-9787-d8ac4b36f52e)


