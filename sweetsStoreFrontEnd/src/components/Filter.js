import React, { useState } from "react";
import { useLocation, Link } from "react-router-dom";
import "../assets/css/style.css";
import Sidebar from "./sideBar";
import axios from "axios";

const SideBarPage = () => {
  const location = useLocation();
  console.log("Location State:", location.state);
  const products = location.state?.products || [];
  const [quantity, setQuantity] = useState(1); 

  const handleAddToCart = (product_id, product) => {
    const token = localStorage.getItem("token");

    const cartItem = {
      product_id: product_id,
      quantity: quantity,
      product_name: product.product_name,
      product_image: product.product_image,
      product_price: product.product_price,
    };

    if (!token) {
      let cart = JSON.parse(sessionStorage.getItem("cart")) || [];

      const existingProductIndex = cart.findIndex(
        (item) => item.product_id === product_id
      );

      if (existingProductIndex !== -1) {
        cart[existingProductIndex].quantity += quantity;
      } else {
        cart.push(cartItem);
      }

      sessionStorage.setItem("cart", JSON.stringify(cart));

      return;
    }

    axios
      .post(
        "http://127.0.0.1:8000/api/addToCartUsersSide",
        {
          product_id: product_id,
          quantity: quantity,
        },
        {
          headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/json",
          },
        }
      )
      .then((response) => {
      })
      .catch((error) => {
        console.error("Error adding to cart:", error);
      });
  };

  return (
    <>
      <br />
      <br />
      <div className="container">
        <div className="content-wrapper">
          <div id="sideBar-container">
            <Sidebar />
          </div>
          <div className="products-grid">
            {products.length > 0 ? (
              products.map((product) => (
                <div key={product.product_id} className="product-card">
                  <div className="product-image">
                    <img
                      src={product.product_image}
                      alt={product.product_name}
                      style={{ objectFit: "contain" }}
                    />
                  </div>
                  <div className="product-info">
                    <div className="product-header">
                      <span className="product-name">
                        {product.product_name}
                      </span>
                      <span className="product-price">
                        {product.product_price} د.أ / كيلو
                      </span>
                    </div>
                    
                    <button
                      onClick={() => handleAddToCart(product.product_id, product)}
                      className="add-to-cart"
                    >
                      <i className="fa-solid fa-cart-shopping"></i>
                      <span>أضف إلى السلة</span>
                    </button>
                    <br />
                    <Link
                      to={`/details?product_id=${product.product_id}`}
                      className="btn-details"
                      key={product.product_id}
                    >
                      عرض التفاصيل
                    </Link>
                  </div>
                </div>
              ))
            ) : (
              <h3 className="text-center"> جاري تحميل المنتجات ... </h3>
            )}
          </div>
        </div>
      </div>
      <br />
      <br />
    </>
  );
};

export default SideBarPage;