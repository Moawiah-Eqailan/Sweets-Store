import React, { useState, useEffect } from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import "../assets/css/style.css";
import { Link, useNavigate } from "react-router-dom";
import axios from "axios";
import Swal from "sweetalert2";

const Checkout = () => {
  const navigate = useNavigate();
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    phone: "",
    address: "",
    city: "",
  });
  const [showForm, setShowForm] = useState(false);
  const [showLoginForm, setShowLoginForm] = useState(false);
  const [loginData, setLoginData] = useState({
    email: "",
    password: "",
  });
  const [error, setError] = useState("");
  const [cartItems, setCartItems] = useState([]);

  const generateOrderNumber = (userId) => {
    const randomNumbers = Math.floor(Math.random() * 1000 + 1);
    return `${userId}${randomNumbers}`;
  };

  useEffect(() => {
    const userData = JSON.parse(localStorage.getItem("user"));

    if (userData) {
      setFormData({
        name: userData.name || "",
        email: userData.email || "",
        phone: userData.phone || "",
        address: userData.address || "",
        city: userData.city || "",
      });
      setShowForm(true);

      axios
        .post("http://127.0.0.1:8000/api/CartUsersSide", {
          user_id: userData.id,
        })
        .then((response) => {
          setCartItems(response.data.cart);
        })
        .catch((error) => {
          console.error("Error fetching cart items:", error);
        });
    } else {
      const storedCart = JSON.parse(sessionStorage.getItem("cart")) || [];
      setCartItems(storedCart);
    }
  }, []);

  const goBack = () => {
    navigate(-1);
  };

  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value,
    });
  };

  const handleLoginChange = (e) => {
    setLoginData({
      ...loginData,
      [e.target.name]: e.target.value,
    });
  };

  const handleContinueWithoutAccount = () => {
    setShowForm(true);
  };

  const handleLogin = () => {
    setShowLoginForm(true);
  };

  const handleLoginSubmit = async (e) => {
    e.preventDefault();
    setError("");

    try {
      const response = await axios.post(
        "http://127.0.0.1:8000/api/loginUsers",
        loginData
      );

      if (response.status === 200) {
        localStorage.setItem("user", JSON.stringify(response.data.user));
        localStorage.setItem("token", response.data.token);

        setFormData({
          name: response.data.user.name || "",
          email: response.data.user.email || "",
          phone: response.data.user.phone || "",
          address: response.data.user.address || "",
          city: response.data.user.city || "",
        });
        setShowForm(true);
        setShowLoginForm(false);

        axios
          .post("http://127.0.0.1:8000/api/CartUsersSide", {
            user_id: response.data.user.id,
          })
          .then((response) => {
            setCartItems(response.data.cart);
          })
          .catch((error) => {
            console.error("Error fetching cart items:", error);
          });
      }
    } catch (error) {
      setError(
        error.response?.data?.message ||
          "حدث خطأ أثناء تسجيل الدخول. يرجى المحاولة مرة أخرى."
      );
    }
  };
  const handleConfirmOrder = async () => {
    const userData = JSON.parse(localStorage.getItem("user"));
    const isLoggedIn = !!userData;

    if (
      !isLoggedIn &&
      (!formData.name ||
        !formData.email ||
        !formData.phone ||
        !formData.city ||
        !formData.address)
    ) {
      Swal.fire({
        icon: "error",
        title: "خطأ",
        text: "يرجى إدخال جميع بيانات المستخدم قبل تأكيد الطلب.",
      });
      return;
    }

    try {
      const orderNumber = generateOrderNumber(userData?.id || "GUEST");
      const orderData = {
        user_id: isLoggedIn ? userData.id : null,
        checkout_num: orderNumber,
        total_product: cartItems.length,
        total_price:
          cartItems.reduce((total, cart) => {
            const price =
              cart.product?.offers ||
              cart.product?.product_price ||
              cart.product_price;
            return total + price * cart.quantity;
          }, 0) + 5,
        status: "pending",
      };
      const orderResponse = await axios.post(
        "http://127.0.0.1:8000/api/order",
        orderData
      );

      if (orderResponse.status === 200) {
        for (const cartItem of cartItems) {
          await axios.post("http://127.0.0.1:8000/api/usersOrderItem", {
            user_id: isLoggedIn ? userData.id : null,
            checkout_num: orderNumber,
            order_id: orderResponse.data.order.id,
            product_id: cartItem.product_id || cartItem.id,
            quantity: cartItem.quantity,
            price:
              cartItem.product?.offers ||
              cartItem.product?.product_price ||
              cartItem.product_price,
            weight: cartItem.weight || null,
          });
        }

        const deliveryData = {
          checkout_num: orderNumber,
          total_price: orderData.total_price,
          name: formData.name,
          email: formData.email,
          phone: formData.phone,
          address: formData.address,
          city: formData.city,
        };

        await axios.post(
          "http://127.0.0.1:8000/api/orderDelivery",
          deliveryData
        );

        Swal.fire({
          icon: "success",
          title: "تم تأكيد الطلب بنجاح",
          text: `طلبك قيد التحضير! رقم الطلب: ${orderNumber}`,
        });

        if (isLoggedIn) {
          await axios.post("http://127.0.0.1:8000/api/clearCartUsersSide", {
            user_id: userData.id,
          });
        } else {
          sessionStorage.removeItem("cart");
        }

        navigate("/");
      }
    } catch (error) {
      console.error("حدث خطأ أثناء تأكيد الطلب:", error);
      Swal.fire({
        icon: "error",
        title: "خطأ",
        text: "حدث خطأ أثناء تأكيد الطلب. يرجى المحاولة مرة أخرى.",
      });
    }
  };
  return (
    <>
      <section className="checkout-section py-5">
        <div className="container">
          <div className="row g-4">
            <div className="col-lg-7">
              {!showForm && !showLoginForm ? (
                <div className="bg-white p-4 rounded-3 shadow-sm">
                  <h4 className="mb-4">تسريع عملية الشراء</h4>
                  <div className="d-grid gap-3">
                    <button
                      className="btn btn-primary w-100"
                      onClick={handleLogin}
                    >
                      تسجيل الدخول
                    </button>
                    <button
                      className="btn btn-outline-secondary w-100"
                      onClick={handleContinueWithoutAccount}
                    >
                      المتابعة بدون حساب
                    </button>
                  </div>
                </div>
              ) : showLoginForm ? (
                <div className="bg-white p-4 rounded-3 shadow-sm">
                  <h4 className="mb-4">تسجيل الدخول</h4>
                  {error && (
                    <div className="alert alert-danger" role="alert">
                      {error}
                    </div>
                  )}
                  <form onSubmit={handleLoginSubmit}>
                    <div className="row g-3">
                      <div className="col-12">
                        <label className="form-label">البريد الإلكتروني</label>
                        <input
                          type="email"
                          className="form-control"
                          value={loginData.email}
                          onChange={handleLoginChange}
                          name="email"
                          required
                        />
                      </div>
                      <div className="col-12">
                        <label className="form-label">كلمة المرور</label>
                        <input
                          type="password"
                          className="form-control"
                          value={loginData.password}
                          onChange={handleLoginChange}
                          name="password"
                          required
                        />
                      </div>
                      <div className="col-12">
                        <button type="submit" className="btn btn-primary w-100">
                          تسجيل الدخول
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              ) : (
                <div className="bg-white p-4 rounded-3 shadow-sm">
                  <h4 className="mb-4">بيانات المستخدم</h4>
                  <form>
                    <div className="row g-3">
                      <div className="col-12">
                        <label className="form-label">الاسم الكامل</label>
                        <input
                          type="text"
                          className="form-control"
                          value={formData.name}
                          onChange={handleChange}
                          name="name"
                          required
                        />
                      </div>
                      <div className="col-md-6">
                        <label className="form-label">البريد الإلكتروني</label>
                        <input
                          type="email"
                          className="form-control"
                          value={formData.email}
                          onChange={handleChange}
                          name="email"
                          required
                        />
                      </div>
                      <div className="col-md-6">
                        <label className="form-label">رقم الهاتف</label>
                        <input
                          type="tel"
                          className="form-control"
                          value={formData.phone}
                          onChange={handleChange}
                          name="phone"
                          required
                        />
                      </div>
                      <div className="col-12">
                        <label className="form-label">العنوان</label>
                        <input
                          type="text"
                          className="form-control"
                          value={formData.address}
                          onChange={handleChange}
                          name="address"
                          required
                        />
                      </div>
                      <div className="col-12">
                        <label className="form-label">المدينة</label>
                        <select
                          className="form-control"
                          value={formData.city}
                          onChange={handleChange}
                          name="city"
                          required
                        >
                          <option value="" disabled>
                            اختر المدينة
                          </option>
                          <option value="عمان">عمان</option>
                          <option value="إربد">إربد</option>
                          <option value="زرقاء">الزرقاء</option>
                          <option value="جرش">جرش</option>
                          <option value="المفرق">المفرق</option>
                          <option value="العقبة">العقبة</option>
                          <option value="معان">معان</option>
                          <option value="السلط">السلط</option>
                          <option value="مادبا">مادبا</option>
                          <option value="الكرك">الكرك</option>
                          <option value="الطفيلة">الطفيلة</option>
                          <option value="البلقاء">البلقاء</option>
                          <option value="عجلون">عجلون</option>
                        </select>
                      </div>
                    </div>
                  </form>
                </div>
              )}

              <div className="payment-method mt-4">
                <h4 className="mb-3">طريقة الدفع</h4>
                <div className="form-check">
                  <label className="form-check-label" htmlFor="cod">
                    الدفع عند الاستلام
                  </label>
                </div>
              </div>
            </div>

            <div className="col-lg-5">
              <div className="order-summary">
                <div className="cart-totals">
                  <h4>ملخص الطلب</h4>
                  <h5>
                    رقم الطلب:{" "}
                    {generateOrderNumber(
                      JSON.parse(localStorage.getItem("user"))?.id || "GUEST"
                    )}
                  </h5>
                  <table className="table">
                    <tbody>
                      <tr className="border-bottom">
                        <th>المنتج</th>
                        <th className="text-end">الكمية</th>
                        <th className="text-end">السعر</th>
                      </tr>
                    </tbody>
                    <tbody>
                      {cartItems.map((cart) => (
                        <tr
                          key={cart.product_id || cart.id}
                          className="border-bottom"
                        >
                          <td>
                            {cart.product?.product_name || cart.product_name}
                          </td>
                          <td className="text-end">
                            {cart.weight
                              ? `${cart.weight} كيلو`
                              : `${cart.quantity} قطعة`}
                          </td>
                          <td className="text-end">
                            {cart.product?.offers ||
                              cart.product?.product_price ||
                              cart.product_price}{" "}
                            د.أ
                          </td>
                        </tr>
                      ))}
                      <tr>
                        <td>رسوم التوصيل</td>
                        <td className="text-end">5 د.أ</td>
                      </tr>
                      <tr>
                        <th>المجموع الفرعي</th>
                        <td className="text-end">
                          {cartItems.reduce((total, cart) => {
                            const price =
                              cart.product?.offers ||
                              cart.product?.product_price ||
                              cart.product_price;
                            return total + price * cart.quantity;
                          }, 0)}{" "}
                          د.أ
                        </td>
                      </tr>
                      <tr>
                        <th>الإجمالي</th>
                        <td className="text-end fw-bold">
                          {cartItems.reduce((total, cart) => {
                            const price =
                              cart.product?.offers ||
                              cart.product?.product_price ||
                              cart.product_price;
                            return total + price * cart.quantity;
                          }, 0) + 5}{" "}
                          د.أ
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div className="button-wrap row g-2 mt-4">
                    <div className="col-md-6">
                      <button
                        onClick={goBack}
                        className="btn btn-outline-secondary w-100"
                      >
                        العودة للسلة
                      </button>
                    </div>
                    <div className="col-md-6">
                      <button
                        type="button"
                        className="btn btn-primary w-100"
                        onClick={handleConfirmOrder}
                      >
                        تأكيد الطلب
                      </button>
                    </div>
                    <div className="col-md-12">
                      <Link
                        to="https://wa.me/962000000000"
                        target="_blank"
                        className="btn btn-success w-100"
                      >
                        <i className="fa-brands fa-whatsapp"></i> تواصل عبر
                        واتساب
                      </Link>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </>
  );
};

export default Checkout;
