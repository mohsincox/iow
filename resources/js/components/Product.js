import React from 'react';
// import axios from 'axios';

export default class Product extends React.Component {

  // onClickAddToCart = (e) => {
  //   const id = e.target.id
  //   // console.log(e.target)
  //   try {
  //     axios.get(`${this.props.path}/add-to-cart/${id}`)
  //     .then((response) => {
  //       if(response.data === "Success"){
  //         console.log("True")
  //       }else{
  //         console.log("False")
  //       }
  //     })
  //     .catch( (error) => {
  //       console.log(error);
  //     });
  //   }catch (error) {
  //     console.error(error);
  //   }
  // }
  render() {
    let count = 0;
    return this.props.product.map( (index, data)=>{
      if(count < 15){
        // let image = index.image;
        // if(image === null){
        //   image = "";
        // }else{
        //   image = index.image.split(",")[0]
        // }
        if(this.props.sort == index.category_id) {
          count++;
          return (
            <article className="single_product" key={`product-${data}`}>
              <figure className="mb-5">
                <div className="product_thumb">
                  <a className="primary_img" href={`${this.props.path}product-details/${index.slug}`}><img src={`${this.props.path}${index.thumbnail_image}`} alt=""/></a>
                </div>
                <figcaption className="product_content">
                    <h3 className="product_name"><a href={`${this.props.path}product-details/${index.slug}`}>{index.name}</a></h3>
                  <div className="price_box">
                    <span className="old_price">{(index.selling_price === null || index.selling_price === "") ? "" : "TK "+index.price}</span>
                    <span className="current_price">{(!(index.selling_price === null || index.selling_price === "")) ? "TK "+index.selling_price : "TK "+index.price}</span>
                  </div>
                </figcaption>
              </figure>
              <div className="add_to_cart">
                  <a title="add to cart" className="shopping_cart_link mr-2" id={index.id} data-image={ index.thumbnail_image } data-name={ index.name } data-price={ (!(index.selling_price === null || index.selling_price === "")) ? index.selling_price : index.price} data-quantity={ index.quantity }>
                      <img src={`${this.props.path}/default/assets/img/icon/white-shopping.svg`} alt="shoping card icon" id={index.id} />
                      Add to cart
                  </a>
                  <a title="Details" className="shopping_cart_link_details" href={`${this.props.path}product-details/${index.slug}`}><span>View Details</span></a>
              </div>
            </article>
          )
        }
      }
    })
  }
}

            {/*<div classNameName="item" key={`product-${data}`}>*/}
              {/*<h3 className="product_name"><a href="product-countdown.html">{index.name}</a></h3>*/}
              {/*<div className="price_box">*/}
                {/*<span className="old_price">{index.price}</span>*/}
                {/*<span className="current_price">{index.selling_price}</span>*/}
              {/*</div>*/}
              {/*<div className="add_to_cart">*/}
                {/*<a href="cart.html" title="add to cart" className="shopping_cart_link"><img*/}
                  {/*src={`http://localhost/igloo/public${image}`} alt="shoping card icon"/><span>Add to cart</span></a>*/}
              {/*</div>*/}
            {/*</div>*/}
