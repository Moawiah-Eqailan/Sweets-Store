import React from "react";
import { useLocation } from "react-router-dom";

const SideBarPage = () => {
  const location = useLocation();
  console.log("Location State:", location.state); 
  const products = location.state?.products || [];

  return (
    <>
      <br />
      <br />
      <h3>المنتجات:</h3>
      {products.length === 0 ? (
        <p>لا توجد منتجات متاحة</p>
      ) : (
        products.map((product) => (
          <div key={product.product_id} className="product-card">
            <p>
              {product.product_name} - {product.product_price}
            </p>
            <div className="product-image">
              <img
                src={product.product_image}
                alt=""
                style={{ objectFit: "contain" }}
              />
            </div>
          </div>
        ))
      )}
      <br />
      <br />
    </>
  );
};

export default SideBarPage;
