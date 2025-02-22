import React, { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import "../assets/css/style.css";
import "bootstrap/dist/css/bootstrap.min.css";

const UserOrders = () => {
  const [orders, setOrders] = useState([]);

  useEffect(() => {
    const fetchOrders = async () => {
      const userData = JSON.parse(localStorage.getItem("user"));

      if (userData) {
        try {
          const response = await fetch(
            `http://127.0.0.1:8000/api/user-orders?user_id=${userData.id}`
          );
          const data = await response.json();
          setOrders(data.orders);
        } catch (error) {
          console.error("Error fetching orders:", error);
        }
      }
    };

    fetchOrders();
  }, []);

  return (
    <>
      <br />
      <br />
      <div className="container">
        <div
          style={{
            textAlign: "center",
            marginBottom: "30px",
          }}
        >
          <h2 style={{ fontFamily: "'Lemonada', serif" }}>طلباتي</h2>
          <span style={{ display: "block", textAlign: "center" }}>
            هنا يمكنك عرض جميع الطلبات التي قمت بتقديمها
          </span>
        </div>

        <div>
          <div className="usersProfile">
            <div className="product-info" style={{ padding: "20px" }}>
              {orders.length > 0 ? (
                <table className="table">
                  <thead>
                    <tr>
                      <th>رقم الطلب</th>
                      <th>التاريخ</th>
                      <th>حالة الطلب</th>
                      <th>المجموع</th>
                      <th>المنتجات</th>
                    </tr>
                  </thead>
                  <tbody>
                    {orders.map((order) => (
                      <tr key={order.id}>
                        <td>{order.checkout_num}</td>
                        <td>{new Date(order.created_at).toLocaleDateString()}</td>
                        <td>{order.status}</td>
                        <td>{order.total_price} د.أ</td>
                        <td>{order.total_product}</td>
                        <td>
                          <ul>
                            {order.order_items?.map((order_items, index) => (
                              <li key={index}>
                                {order_items.id} - {order_items.name} × {order_items.order_id} د.أ
                              </li>
                            ))}
                          </ul>
                        </td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              ) : (
                <div style={{ textAlign: "center", padding: "20px" }}>
                  <p>لا توجد طلبات لعرضها.</p>
                </div>
              )}
            </div>
          </div>
        </div>
      </div>
      <br />
      <br />
    </>
  );
};

export default UserOrders;
