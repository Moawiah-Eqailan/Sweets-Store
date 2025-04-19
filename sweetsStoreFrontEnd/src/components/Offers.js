import React, { useEffect, useState } from "react";
import "../assets/css/style.css";
import Sidebar from "./sideBar";
import axios from "axios";
import "bootstrap/dist/css/bootstrap.min.css";
import { Link } from "react-router-dom";

const Offers = () => {
  const [products, setProducts] = useState([]);
  const [quantity, setQuantity] = useState(1);

  useEffect(() => {
    axios
      .get("http://127.0.0.1:8000/api/products")
      .then((response) => {
        const productsWithOffers = response.data.products.filter(
          (product) => product.offers && product.offers.trim() !== ""
        );
        setProducts(productsWithOffers);
      })
      .catch((error) => {
        console.error("Error fetching products:", error);
      });
  }, []);

  const handleAddToCart = (product_id) => {
    const token = localStorage.getItem("token");

    const cartItem = {
      product_id: product_id,
      quantity: quantity,
    };

    if (token) {
      axios
        .post(
          "http://127.0.0.1:8000/api/addToCartUsersSide",
          cartItem,
          {
            headers: {
              Authorization: `Bearer ${token}`,
              "Content-Type": "application/json",
            },
          }
        )
        .then((response) => {
          alert("تم إضافة المنتج إلى السلة!");
        })
        .catch((error) => {
          console.error("Error adding to cart:", error);
          alert("حدث خطأ أثناء إضافة المنتج إلى السلة!");
        });
    } else {
      axios
        .post("http://127.0.0.1:8000/api/addToCartUsersSide", cartItem)
        .then((response) => {
          alert("تم إضافة المنتج إلى السلة!");
        })
        .catch((error) => {
          console.error("Error adding to cart:", error);
          alert("حدث خطأ أثناء إضافة المنتج إلى السلة!");
        });
    }
  };

  return (
    <>
      <br />
      <br />
      <div className="container">
        <div
          style={{
            textAlign: "center",
            color: "#5d4037",
            marginBottom: "30px",
          }}
        >
          <h2 style={{ fontFamily: "'Lemonada', serif" }}>العروض الخاصة</h2>
          <span
            style={{ display: "block", color: "#795548", textAlign: "center" }}
          >
            احصل على هذه العروض المذهلة قبل أن تنتهي!
          </span>
        </div>

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
                        {product.offers} د.أ / كيلو
                      </span>
                    </div>
                    <button
                      onClick={() => handleAddToCart(product.product_id)}
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
              <h3 className="text-center">جاري تحميل المنتجات...</h3>
            )}
          </div>
        </div>
      </div>
      <br />
      <br />
    </>
  );
};

export default Offers;