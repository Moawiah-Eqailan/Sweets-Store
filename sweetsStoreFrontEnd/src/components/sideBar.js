import React, { useEffect, useState } from "react";
import axios from "axios";

import "../assets/css/style.css";
import "font-awesome/css/font-awesome.min.css";
import { Link, useNavigate } from "react-router-dom";

const Sidebar = () => {
  const [activeDropdown, setActiveDropdown] = useState(null);
  const [categories, setCategories] = useState([]);
  const [items, setItems] = useState([]);
  const [products, setProducts] = useState([]);
  const navigate = useNavigate();
  const [selectedItems, setSelectedItems] = useState([]);

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

  useEffect(() => {
    axios
      .get("http://127.0.0.1:8000/api/sideBar")
      .then((response) => {
        setItems(response.data.item);
      })
      .catch((error) => {
        console.error("Error fetching items:", error);
      });
  }, []);

  const toggleDropdown = (categoryId) => {
    setActiveDropdown(activeDropdown === categoryId ? null : categoryId);
  };
  const handleCheckboxChange = (itemId) => {
    axios
      .get(`http://127.0.0.1:8000/api/SubFilter?item_id=${itemId}`)
      .then((response) => {
        console.log("Fetched products:", response.data.products);
        setProducts(response.data.products);

        navigate("/Filter", {
          state: { products: response.data.products || [] },
        });
      })
      .catch((error) => {
        console.error("Error fetching products:", error);
      });
    setSelectedItems((prevSelectedItems) => {
      if (prevSelectedItems.includes(itemId)) {
        return prevSelectedItems.filter((id) => id !== itemId);
      } else {
        return [...prevSelectedItems, itemId];
      }
    });
  };

  return (
    <div className="sidebar">
      <div className="category-dropdown">
        <Link to="/Offers" className="dropdown-button">
          <i className="fa-solid fa-circle"></i>
          <span>العروض</span>
        </Link>
      </div>

      {categories.length === 0 ? (
        <p style={{ textAlign: "center" }}></p>
      ) : (
        categories.map((category) => (
          <div key={category.category_id} className="category-dropdown">
            <Link
              to={`/products?category_id=${category.category_id}`}
              key={category.category_id}
            >
              <button
                className="dropdown-button"
                onClick={() => toggleDropdown(category.category_id)}
              >
                
                <span>{category.category_name}</span>
                <i className="fa-solid fa-chevron-down chevron-icon"></i>
              </button>
              </Link>
            <div
              className={`dropdown-content ${
                activeDropdown === category.category_id ? "active" : ""
              }`}
              >
              {items.filter((item) => item.category_id === category.category_id)
                .length === 0 ? (
                <p style={{ textAlign: "center" }}> قريبًا </p>
              ) : (
                items
                  .filter((item) => item.category_id === category.category_id)
                  .map((item) => (
                    <label key={item.id} className="dropdown-item">
                      <input
                        type="checkbox"
                        name={item.item_name}
                        value={item.id}
                        checked={selectedItems.includes(item.id)}
                        onChange={() => handleCheckboxChange(item.id)}
                      />
                      {item.item_name}
                    </label>
                  ))
              )}
            </div>
          </div>
        ))
      )}
    </div>
  );
};

export default Sidebar;
