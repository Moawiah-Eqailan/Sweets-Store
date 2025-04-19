import React, { useEffect, useState } from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import "../assets/css/style.css";
import { Link, useNavigate } from "react-router-dom";
import axios from "axios";
import Swal from "sweetalert2";

const Cart = () => {
  const navigate = useNavigate();
  const [cartItems, setCartItems] = useState([]);
  const isLoggedIn = !!localStorage.getItem("user");

  useEffect(() => {
    const token = localStorage.getItem("token");
    if (isLoggedIn && token) {
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    }

    axios
      .post("http://127.0.0.1:8000/api/CartUsersSide")
      .then((response) => {
        setCartItems(response.data.cart);
      })
      .catch((error) => {
        console.error("Error fetching cart items:", error);
        Swal.fire({
          icon: "error",
          title: "خطأ",
          text: "فشل جلب عناصر السلة. حاول مرة أخرى.",
        });
      });

    return () => {
      delete axios.defaults.headers.common['Authorization'];
    };
  }, []);

  const handleRemoveItem = (cartId) => {
    axios
      .delete(`http://127.0.0.1:8000/api/cart/${cartId}`)
      .then(() => {
        setCartItems(cartItems.filter((cart) => cart.id !== cartId));
        Swal.fire({
          icon: "success",
          title: "تم الحذف بنجاح",
          text: "تم حذف العنصر من السلة!",
        });
      })
      .catch((error) => {
        console.error("حدث خطأ أثناء حذف العنصر من السلة:", error);
        Swal.fire({
          icon: "error",
          title: "خطأ",
          text: "فشل حذف العنصر من السلة!",
        });
      });
  };

  const goBack = () => {
    navigate(-1);
  };

  return (
    <section className="py-2 my-2 py-md-5 my-md-5" dir="rtl">
      <div className="container">
        <div className="row g-md-5">
          <div className="col-md-7">
            <div className="cart-box bg-white rounded shadow-sm p-3">
              <div className="cart-header d-flex justify-content-between border-bottom pb-2">
                <span className="fw-bold">المنتج</span>
                <span className="fw-bold">الاسم</span>
                <span className="fw-bold">الكمية</span>
                <span className="fw-bold">السعر</span>
                <span className="fw-bold">حذف</span>
              </div>
              {cartItems.length > 0 ? (
                cartItems.map((cart) => (
                  <div
                    key={cart.id}
                    className="cart-item d-flex align-items-center justify-content-between py-3 border-bottom"
                  >
                    <div className="d-flex align-items-center gap-3">
                      <img
                        src={cart.product?.product_image}
                        alt={cart.product?.product_name}
                        className="rounded"
                        style={{
                          width: "80px",
                          height: "80px",
                          objectFit: "contain",
                        }}
                      />
                      <span>{cart.product?.product_name}</span>
                    </div>
                    <span className="fw-bold">
                      {cart.weight
                        ? `${cart.weight} كيلو`
                        : `${cart.quantity} قطعة`}
                    </span>
                    <span className="fw-bold">
                      {cart.product?.offers || cart.product?.product_price} د.أ
                    </span>
                    <button
                      className="btn btn-danger btn-sm"
                      onClick={() => handleRemoveItem(cart.id)}
                    >
                      <i className="fas fa-trash"></i>
                    </button>
                  </div>
                ))
              ) : (
                <p style={{ textAlign: "center", margin: "12px" }}>
                  لا توجد عناصر في السلة.
                </p>
              )}
            </div>
          </div>

          <div className="col-md-5">
            <div className="cart-totals p-4 bg-white rounded shadow-sm">
              <h4 className="mb-3">إجمالي السلة</h4>
              <table className="table">
                <tbody>
                  <tr>
                    <th>المجموع الفرعي</th>
                    <td>
                      {cartItems.reduce((total, cart) => {
                        const price = cart.product?.offers || cart.product?.product_price || 0;
                        return total + price * cart.quantity;
                      }, 0)}{" "}
                      د.أ
                    </td>
                  </tr>
                  <tr>
                    <th>الإجمالي</th>
                    <td className="fw-bold">
                      {cartItems.reduce((total, cart) => {
                        const price = cart.product?.offers || cart.product?.product_price || 0;
                        return total + price * cart.quantity;
                      }, 0)}{" "}
                      د.أ
                    </td>
                  </tr>
                </tbody>
              </table>
              <div className="d-flex gap-2">
                <button
                  onClick={goBack}
                  className="btn btn-outline-secondary flex-grow-1"
                >
                  استمرار التسوق
                </button>

                {cartItems.length > 0 && (
                  <Link to="/checkout" className="btn btn-primary flex-grow-1">
                    الدفع
                  </Link>
                )}
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default Cart;