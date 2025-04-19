import "../assets/css/style.css";
import "bootstrap/dist/css/bootstrap.min.css";
import { Link } from "react-router-dom";
import React, { useEffect, useState } from "react";
import axios from "axios";

const BestProducts = () => {
  const [bestProducts, setBestProducts] = useState([]);
  const [categories, setCategories] = useState([]);
  const [quantity, setQuantity] = useState(1);

  useEffect(() => {
    axios
      .get("http://127.0.0.1:8000/api/topProducts")
      .then((response) => {
        setBestProducts(response.data.top_products);
      })
      .catch((error) => {
        console.error("Error fetching top products:", error);
      });
  }, []);

  useEffect(() => {
    axios
      .get("http://127.0.0.1:8000/api/app")
      .then((response) => {
        setCategories(response.data.categories);
      })
      .catch((error) => {
        console.error("Error fetching categories:", error);
      });
  }, []);

  const increaseQuantity = () => setQuantity((prev) => prev + 1);
  const decreaseQuantity = () => setQuantity((prev) => (prev > 1 ? prev - 1 : 1));

  const handleAddToCart = (product_id, product) => {
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
      <section
        className="about-us py-5"
        dir="rtl"
        style={{
          background: "linear-gradient(180deg, #fff8e1 0%, #ffffff 100%)",
          fontFamily: "'Cairo', sans-serif",
          margin: "0",
          padding: "0",
        }}
      >
        <div className="container">
          <div className="row justify-content-center text-center">
            <div className="col-md-6">
              <h2 className="category-title">مرحبا بكم</h2>
              <p>
                مخبزنا الحرفي مخصص لصنع الحلويات اللذيذة التي تسعد الحواس وتترك
                انطباعًا دائمًا. اكتشف عالمًا من النكهات الرائعة والحرفية
                المتميزة بينما ندعوك لتجربة جوهر الخبز الفاخر.
              </p>
            </div>
          </div>
        </div>
      </section>

      <section className="best-products py-5" id="best-products" dir="rtl">
        <div className="container">
          <div className="row justify-content-center text-center pb-5">
            <div className="col-md-6">
              <h2
                className="category-title"
                style={{ fontFamily: "'Lemonada', serif;" }}
              >
                الأكثر مبيعاً
              </h2>
              <span className="text-muted">
                استمتع بأذواقنا المتنوعة من المخبوزات الطازجة
              </span>
            </div>
          </div>
          <div className="products-grid">
            {bestProducts.map((product) => (
              <div className="product-card-top-products" key={product.product_id}>
                <div className="product-image-top-products">
                  <img
                    src={product.product_image}
                    alt={product.product_name}
                    style={{ objectFit: "contain" }}
                  />
                </div>
                <div className="product-info-top-products">
                  <div className="product-header-top-products">
                    <span className="product-name-top-products">
                      {product.product_name}
                    </span>
                    <span className="product-price-top-products">
                      {product.product_price} د.أ / ك
                    </span>
                  </div>
                  <button
                    onClick={() => handleAddToCart(product.product_id, product)}
                    className="add-to-cart"
                  >
                    إضافة للسلة
                  </button>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      <section className="shop-categories" dir="rtl" id="categories">
        <h2 className="category-title">تسوق حسب التصنيف</h2>
        <div className="categories-grid">
          {categories.map((category) => (
            <Link
              to={`/products?category_id=${category.category_id}`}
              className="category-card"
              key={category.category_id}
            >
              <div className="category-image-wrapper">
                <img
                  src={category.category_image}
                  className="category-image"
                  alt={category.category_name}
                />
              </div>
              <p className="category-name">{category.category_name}</p>
            </Link>
          ))}
        </div>
      </section>
    </>
  );
};

export default BestProducts;