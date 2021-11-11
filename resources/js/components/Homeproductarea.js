import React from 'react';
import ReactDOM from 'react-dom';
import OwlCarousel from 'react-owl-carousel';
// import '../../../node_modules/owl.carousel/dist/assets/owl.carousel.css';
// import '../../../node_modules/owl.carousel/dist/assets/owl.theme.default.css';
import Product from "./Product";

export default class Homeproductarea extends React.Component {
  // state = {
  //   product: null
  // }
  constructor(props) {
    super(props);
    const {category} = this.props
    let categoryId = null
    if (category.length > 0){
      categoryId = category[0].id
    }
    this.state = {
      ...this.props,
      sort: categoryId,
      responsive:{
        // 0: {
        //   items: 1,
        // },
        // 576: {
        //   items: 1,
        // },
        // 768: {
        //   items: 2,
        // },
        // 992: {
        //   items: 3,
        // },
        // 1200: {
        //   items: 4,
        // },

        0: {
          items: 1,
        },
        450: {
          items: 1,
        },
        600: {
          items: 2,
        },
        1000: {
          items: 4,
        },
      },
    }
  }
  //
  // componentDidMount(){
  //   console.log(this.props.product)
  // }

  onClickCategory = (e) => {
    const sort = e.target.id
    this.setState({
      sort: sort
    })
    setTimeout(() => {
      this.setState({ sort: sort });
    }, 300);
  }
  renderCategory(){
    return this.state.category.map( (index, data)=>{
        return (
          <li key={`category-${data}`}>
            <button  id={index.id} onClick={this.onClickCategory}>{index.name}</button>
          </li>
        )
      })
  }

  render() {
    if(this.state.product !== null && this.state.category !== null ) {
      return (
        <div>
          <div className="container">
            <div className="row">
              <div className="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div className="title mt-4">
                  <h1>Choose an Ice-cream for your LOVE</h1>
                  <h3>Our Products</h3>
                </div>
              </div>
            </div>
          </div>
          <div className="product_bg">
            <div className="container">
              <div className="ice_cream_flavors">
                <ul>
                  {this.renderCategory()}
                </ul>
              </div>
              <div className="product_carousel product_column5">
                <OwlCarousel
                  className="owl-theme"
                  loop={true}
                  autoplay={true}
                  margin={10}
                  nav={true}
                  items="4"
                  responsive={this.state.responsive}
                  navText={['<i class="ion-ios-arrow-left"></i>', '<i class="ion-ios-arrow-right"></i>']}
                  dots={false}
                >
                  <Product product={this.state.product} sort={this.state.sort} path={this.state.path}/>
                </OwlCarousel>
              </div>
            </div>
          </div>
        </div>
      );
    }
    return null;
  }
}

if (document.getElementById('homeproductarea')) {
  var product = $('#homeproductarea').data('product')
  var category = $('#homeproductarea').data('category')
  var path = $('#homeproductarea').data('path')
  ReactDOM.render(<Homeproductarea product={product} category={category} path={path}/>, document.getElementById('homeproductarea'));}