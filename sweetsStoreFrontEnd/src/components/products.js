import { useLocation } from "react-router-dom";
import { useEffect, useState } from "react";
import axios from "axios";
import Sidebar from "./sideBar";
import { Link } from "react-router-dom";

const Products = () => {
  const location = useLocation();
  const queryParams = new URLSearchParams(location.search);
  const categoryId = queryParams.get("category_id");

  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [categories, setCategories] = useState([]);
  const [quantity, setQuantity] = useState(1);

  useEffect(() => {
    if (categoryId) {
      axios
        .get(`http://127.0.0.1:8000/api/products?category_id=${categoryId}`)
        .then((response) => {
          if (response.data && response.data.status === 200) {
            setProducts(response.data.products || []);
          } else {
            setProducts([]);
            setError("لم يتم العثور على منتجات.");
          }
          setLoading(false);
        })
        .catch(() => {
          setError("حدث خطأ أثناء تحميل المنتجات.");
          setLoading(false);
        });
    } else {
      setLoading(false);
      setError("لم يتم تحديد تصنيف.");
    }

    axios
      .get("http://127.0.0.1:8000/api/app")
      .then((response) => {
        setCategories(response.data.categories);
      })
      .catch((error) => {
        console.error("Error fetching categories:", error);
      });
  }, [categoryId]);

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
          {categories
            .filter(
              (category) => category.category_id === parseInt(categoryId)
            )
            .map((category) => (
              <h2
                style={{ fontFamily: "'Lemonada', serif" }}
                key={category.category_id}
              >
                {category.category_name}
              </h2>
            ))}

          <span
            style={{ display: "block", color: "#795548", textAlign: "center" }}
          >
            استمتع بتشكيلة متنوعة من المنتجات
          </span>
        </div>

        <div className="content-wrapper">
          <div id="sideBar-container">
            <Sidebar />
          </div>

          <div className="products-grid">
            {loading ? (
              <p className="loading-text">جاري تحميل المنتجات...</p>
            ) : error ? (
              <p className="error-text">{error}</p>
            ) : products.length > 0 ? (
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

export default Products;