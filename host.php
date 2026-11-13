<!DOCTYPE html>
<html>
     <head>

        <title> Localhost </title>
        <link rel="stylesheet" href="style1.css">
     </head>
<body>
       <header class="header">
       <a href="#home" class="logo">
       CJ <span> Rosales </span>
       </a>

     <nav class="nav-menu">
                    <a href="#home">Home</a>
                    <a href="#product">Product</a>
                    <a href="#about">About</a>
                    <a href="#admin">Admin</a>
                    <a href="app.html" class="nav-button">Sign In</a>
                </nav>
            </div>
        </header>


           <?php
           include 'db.php';

$sql = "SELECT * FROM products_new";
$results = $conn->query ($sql);
?>
         <div class="products">
          <?php
         if ($results && $results->num_rows > 0) {
        while ($product = $results->fetch_assoc()) {
       ?>
      <main>
     </div>

            <div class="image">
              <img src="image/<?php echo $product ['Image']; ?>" alt ="image">
              </div>
              
              <div class="modal-overlay" id="buynowmodal">
  <div class="checkout-modal">
    <div class="modal-header">
      <h2> Product checkout </h2>
      <button type="button" class="modal-close">
      <onclick="closeBuyNow()">
      &times;
    </button>
    </div>
  </div>
</div>

<form id="checkoutForm">
<div class="checkout-product">
</div>
<div class="checkout-image">
  <imd id="CheckoutImage" src="" alt="Product Image">
</div>

<div class="checkout-details">
  <h3 id="checkoutname"> Product Name </h3>

  <p>
    Price:
    <strong id="checkoutprice"> $0.00 </strong>
</p>

<p>
  Available Stocks;
  <strong id="checkoutStocks">0</strong>
</p>

<hr>

<h3 class="form-heading"> Customers Information</h3>
<div class="form-group">
  <label for="CustomersName"> Full Name </label>

  <input type="text"
  id="customername"
  name="customer_name"
  placeholder="Enter your Full Name"
  required>
</div>

<div class="form-group">
 <label  for="CustomersAddress"> Delivery Address </label>
<textarea
id="CustomersAddress"
name="customer_address"
placeholder="Enter your complete delivery address"
rows="3"
required> </textarea>
</div>

<div class="form-group">
  <label for="Customer Contact"> Contact Number </label>
  <input type="tel"
  id="Customercontact"
  name="Customer_contact"
  placeholder="Enter your contact number"
  required>
</div>

<div class="form-group">
  <label for="orderQuantity"> Quantity to Order </label>
  <input type= "number"
  id="orderQuantity"
  name="quantity"
  value="1"
  min="1"
  step="1"
  required>
  <small id="quantityMessage">
    Minimun Order: 1
  </small>
</div>

<div class="checkout-total">
  <span> Total Amount: </span>
  <strong id="CheckoutTotal">$0.00</strong>
</div>

<div class="checkout-buttons">
  <button type="button"
   class="cancel-btn"
   onclick="closeBuyNow()">
   cancel
  </button>

  <button type="submit"
     class="purchase-btn">
     Confirm purchase
  </button>
</div>
</form>

<div class="fruits">
    <a> Nature </a>
</div>

            <div class="price">
              <a> 1$ </a>
            </div>

<div class="stocks"> 
    <a> Stocks:100 </a>
</div>

            <div class="button">
              <button> Buy Now </button>
              <button> Add to Cart </button>
            </div>

            <div class="fruits">
   
    <?php
     }
    } else {
    echo "<p> No products available.</p>";
   }
    $conn->close();
  ?>

</main>
</body>
</html>

<script>

  let selectedProduct = {
    id: 0,
    name: "",
    price: 0,
    stocks: 0,
    image: ""
  };

  function openbuynow(id, name, price, stocks, image) {
    selectedProduct.id = Number (id);
    selectedProduct.name = name;
    selectedProduct = Number(price);
    selectedProduct.stocks = Nmuber(stocks);

    selectedProduct.image = image.startwith("images/")
    ? image
    : "images/" + image;

     document.getElementById("checkoutImage").src =
     selectedProduct.image;

      document.getElementById("checkoutName").textContent =
       selectedProduct.name;

       document.getElementById("checkoutPrice").textContent =
       "$" +  selectedProduct.price;.toFixed(2);

       document.getElementById("checkoutStocks").textContent =
       selectedProduct.stocks;

       document.getElementById("checkoutForm").reset();
       document.getElementById("buynowmodal").classList.add("active");

       const quantityInput =  document.getElementById("orderQuantity");

       quantityInput.min = 1;
       quantityInput.max = selectedProduct.stocks;
       quantityInput.value = 1;

        document.getElementById("quantityMessage").textContent =
        "Minimum order:1 | Maximum order:"
        selectedProduct.stocks;

        updateCheckOutTotal()

         document.getElementById("buynowmodal").classList.add("active");

         document.body.style.overflow = "hidden";
  }

  function closeBuyNow() {
     document.getElementById("buynowmodal").classList.remove("active");
     document.body.style.overflow = "auto";
  }

  function updateCheckOutTotal() {

  const quantityInput =  document.getElementById("orderQuantity");
  let quantity = Number(quantityInput.value);
  if (Number.is_Integer(quantity) || quantity < 1){
    quantity = 1;
  }
  
  const total = selectedProduct.price * quantity;
   document.getElementById("checkoutTotal").textContent =
   "$" + total.toFixed(2)
  }

   document.getElementById("orderQuantity").addEventListener("input", function () {
    let quantity = Number(this.value);

    const message=  document.getElementById("quantityMessage");

    if (this.value === "") {
      message.textContent = "Please enter a quantity.";
      updateCheckTotal();
      return;
    }

    if (!Number .isInteger(quantity) || quantity < 1) {
      message.textContent = "Quantity must be at least 1.";
    }

    else if (quantity > selectedProduct.stocks) {
      message.textContent =
      "Only" + selectedProduct.stocks + "stocks available.";
    }

    else {
      message.textContent =
      "Minimum order: 1 | Maximum order:" +
      selectedProduct.stocks;
    }
    updateCheckOutTotal();
   })

    document.getElementById("checkoutForm").addEventListener("submit,", function (event) {
      event.preventDefault();

      const customerName =  document.getElementById("CustomerName").value.trim();
      const customerAddress =  document.getElementById("CustomerAddress").value.trim();
      const customerContact =  document.getElementById("CustomerContact").value.trim();
      const quantity = Number  (document.getElementById("OrderQuantity").value.);

      if (!CustomerName || customerAddress || !CustomerContact) {

      alert ("Please complete all customer information");
      return;
      }

      if (!Number.isInteger(quantity) ||
      quantity < 1 ||
      quantity > selectedProduct.stocks) {
        
      alert("Please enter a valid quantity within the available stocks.");
      return;
      }

      const total = selectedProduct.price * quantity;

      alert(
        "ORDER DETAILS\n\n" +
        "Product:" + selectedProduct.name + "\n" +
        "Price: $" + selectedProduct.price.toFixed(2) + "\n" +
        "Quantity" + quantity + "\n" +
        "Total Amount: $" + total.toFixed(2) + "\n\n" +
        "Customer:" + CustomerName + "\n" +
        "Address:" + CustomerAddress + "\n" +
        "Contact:" + CustomerContact 
      );

      closeBuyNow();
   });

   </script>
   </html>