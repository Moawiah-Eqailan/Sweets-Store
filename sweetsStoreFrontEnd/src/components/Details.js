import React, { useEffect, useState } from "react";
import "../assets/css/style.css";
import axios from "axios";
import "bootstrap/dist/css/bootstrap.min.css";
import { Link } from "react-router-dom";
import { useLocation } from "react-router-dom";

const Details = () => {
  const [product, setProduct] = useState(null);
  const [relatedProducts, setRelatedProducts] = useState([]);
  const [quantity, setQuantity] = useState(1);
  const location = useLocation();

  const queryParams = new URLSearchParams(location.search);
  const product_id = queryParams.get("product_id");

  useEffect(() => {
    axios
      .get(`http://127.0.0.1:8000/api/products?product_id=${product_id}`)
      .then((response) => {
        setProduct(response.data.products[0]);

        return axios.get(
          `http://127.0.0.1:8000/api/products?category=${response.data.products[0].item}`
        );
      })
      .then((res) => {
        const filteredProducts = res.data.products.filter(
          (p) => p.id !== product_id
        );
        setRelatedProducts(filteredProducts.slice(0, 6));
      })
      .catch((error) => {
        console.error("Error fetching products:", error);
      });
  }, [product_id]);

  const increaseQuantity = () => setQuantity((prev) => prev + 1);
  const decreaseQuantity = () =>
    setQuantity((prev) => (prev > 1 ? prev - 1 : 1));

  const handleAddToCart = () => {
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
      
      const existingProductIndex = cart.findIndex(item => item.product_id === product_id);
      
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
      <section className="position-relative py-5">
        <div className="container">
          {product ? (
            <>
              <h2 className="text-center mb-5 fs-1">{product.product_name}</h2>
              <div className="row justify-content-center">
                <div className="col-12">
                  <div className="card product-card shadow">
                    <div className="row g-0">
                      <div className="col-md-5">
                        <img
                          src={product.product_image}
                          className="product-image-details rounded-start"
                          style={{ objectFit: "contain", width: "100%" }}
                          alt={product.product_name}
                        />
                      </div>
                      <div className="col-md-7">
                        <div className="card-body p-4">
                          <h3 className="card-title fs-2 mb-3">
                            {product.product_name}
                          </h3>
                          <p className="product-description">
                            {product.description}
                          </p>
                          <p className="product-price">
                            السعر:{" "}
                            <span className="product-price">
                              {product.offers ? (
                                <>
                                  <del style={{ color: "#000" }}>
                                    {product.product_price}
                                  </del>{" "}
                                  {product.offers} د.أ / كيلو
                                </>
                              ) : (
                                <>{product.product_price} د.أ / كيلو</>
                              )}
                            </span>
                          </p>
                          <div className="mt-4 d-flex align-items-center gap-3">
                            <button className="add-to-kilo-details">
                              1000 جرام
                            </button>
                            <button className="add-to-kilo-details">
                              2000 جرام
                            </button>
                          </div>
                          <div className="mt-4 d-flex align-items-center gap-3">
                            <div
                              style={{
                                alignItems: "center",
                                gap: "10px",
                                border: "1px solid #ddd",
                                borderRadius: "8px",
                                padding: "5px 10px",
                              }}
                            >
                              <button
                                onClick={decreaseQuantity}
                                style={{
                                  padding: "5px 10px",
                                  fontSize: "18px",
                                  cursor: "pointer",
                                  border: "none",
                                  background: "#eee",
                                  borderRadius: "5px",
                                }}
                              >
                                -
                              </button>

                              <input
                                type="text"
                                value={quantity}
                                readOnly
                                style={{
                                  width: "40px",
                                  textAlign: "center",
                                  fontSize: "18px",
                                  border: "none",
                                  background: "transparent",
                                }}
                              />

                              <button
                                onClick={increaseQuantity}
                                style={{
                                  padding: "5px 10px",
                                  fontSize: "18px",
                                  cursor: "pointer",
                                  border: "none",
                                  background: "#eee",
                                  borderRadius: "5px",
                                }}
                              >
                                +
                              </button>
                            </div>
                          </div>
                          <br />
                          <button
                            onClick={handleAddToCart}
                            className="add-to-cart-details"
                          >
                            إضافة للسلة
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
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
                  <h2 style={{ fontFamily: "'Lemonada', serif" }}>
                    منتجات ذات صلة
                  </h2>
                  <span
                    style={{
                      display: "block",
                      color: "#795548",
                      textAlign: "center",
                    }}
                  ></span>
                </div>
                <div className="products-grid">
                  {relatedProducts.length > 0 ? (
                    relatedProducts.map((product) => (
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
                            onClick={handleAddToCart}
                            className="add-to-cart"
                          >
                            إضافة للسلة
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
                    <h3 className="text-center">جاري تحميل المنتجات ...</h3>
                  )}
                </div>
              </div>
            </>
          ) : (
            <h3 className="text-center">جاري تحميل المنتج ...</h3>
          )}
        </div>
      </section>
    </>
  );
};

export default Details;