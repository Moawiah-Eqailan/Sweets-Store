import React, { useEffect, useState } from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import "../assets/css/style.css";
import { Link, useNavigate } from "react-router-dom";
import axios from "axios";
import Swal from "sweetalert2";

const Cart = () => {
  const navigate = useNavigate();
  const [cartItems, setCartItems] = useState([]);
  const isLoggedIn = localStorage.getItem("user");

  useEffect(() => {
    const user = JSON.parse(localStorage.getItem("user"));

    if (!user || !user.id) {
      const storedCart = JSON.parse(sessionStorage.getItem("cart")) || [];
      setCartItems(storedCart);

      return;
    }

    const user_id = user.id;

    axios
      .post("http://127.0.0.1:8000/api/CartUsersSide", { user_id })
      .then((response) => {
        setCartItems(response.data.cart);
      })
      .catch((error) => {
        console.error("Error fetching cart items:", error);
      });
  }, []);

  const handleRemoveItem = (cartId) => {
    if (isLoggedIn) {
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
            text: "تم حذف العنصر من السلة!",
          });
        });
    } else {
      const storedCart = JSON.parse(sessionStorage.getItem("cart")) || [];
      const updatedCart = storedCart.filter(
        (cart) => cart.product_id !== cartId
      );
      sessionStorage.setItem("cart", JSON.stringify(updatedCart));
      setCartItems(updatedCart);
      Swal.fire({
        icon: "success",
        title: "تم الحذف بنجاح",
        text: "تم حذف العنصر من السلة!",
      });
    }
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
                    key={cart.product_id}
                    className="cart-item d-flex align-items-center justify-content-between py-3 border-bottom"
                  >
                    <div className="d-flex align-items-center gap-3">
                      {isLoggedIn ? (
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
                      ) : (
                        <img
                          src={cart.product_image}
                          alt={cart.product_name}
                          className="rounded"
                          style={{
                            width: "80px",
                            height: "80px",
                            objectFit: "contain",
                          }}
                        />
                      )}
                      {isLoggedIn ? (
                        <span>{cart.product?.product_name}</span>
                      ) : (
                        <span>{cart.product_name}</span>
                      )}
                    </div>
                    <span>{cart.quantity} كيلو</span>
                    <span className="fw-bold">
                      {isLoggedIn
                        ? cart.product?.product_price
                        : cart.product_price}{" "}
                      د.أ
                    </span>
                    {isLoggedIn ? (
                      <button
                        className="btn btn-danger btn-sm"
                        onClick={() => handleRemoveItem(cart.id)}
                      >
                        <i className="fas fa-trash"></i>
                      </button>
                    ) : (
                      <button
                        className="btn btn-danger btn-sm"
                        onClick={() => handleRemoveItem(cart.product_id)}
                      >
                        <i className="fas fa-trash"></i>
                      </button>
                    )}
                  </div>
                ))
              ) : (
                <p style={{textAlign:"center" , margin:'12px'}}>لا توجد عناصر في السلة.</p>
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
                        return isLoggedIn
                          ? total +
                              (cart.product?.product_price || 0) * cart.quantity
                          : total + (cart.product_price || 0) * cart.quantity;
                      }, 0)}{" "}
                      د.أ
                    </td>
                  </tr>
                  <tr>
                    <th>الإجمالي</th>
                    <td className="fw-bold">
                      {cartItems.reduce((total, cart) => {
                        return isLoggedIn
                          ? total +
                              (cart.product?.product_price || 0) * cart.quantity
                          : total + (cart.product_price || 0) * cart.quantity;
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
                <Link to="/checkout" className="btn btn-primary flex-grow-1">
                  الدفع
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default Cart;
