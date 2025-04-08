const box = document.querySelector('.donate__cards');
const info = document.querySelector('.donate__info');
const form = document.querySelector('.donate__form');

const backButton = document.querySelector('.donate__control-back');

let selection = 'category'; // category, product, form
let lastCategory = 1;

/* form */
let type = true; // true = user; false = pay

const sendButton = document.querySelector('.donate__form-button');
const sendText =  document.querySelector('.donate__form-btntext');
const sendImage =  document.querySelector('.donate__form-btnimage');

const amountItem = document.querySelector('.donate__form-amount');

const backFormButton = document.querySelector('.donate__form-back');
const formButtons = document.querySelector('.donate__form-buttons');

const formPay = document.querySelector('.donate__form-pay');

const priceValue = document.querySelector('.donate__form-pricevalue');

const promocode = document.getElementById('form-promo');
const formAmount = document.getElementById('form-amount');
const formUser = document.getElementById('form-user');
const formProduct = document.getElementById('form-product');

function setSelection(select, nulled = false) {
  selection = select;
  if(select == 'category') {
    if(nulled) {
      info.textContent = 'Не найдены категории товаров';
    } else {
      info.textContent = 'Выберите категорию:';
    }
    backButton.classList.add('hide');
  } else if(select == 'product') {
    if(nulled) {
      info.textContent = 'Не найдены товары';
    } else {
      info.textContent = 'Выберите товар:';
    }
    amountItem.classList.remove('hide');
    backButton.classList.remove('hide');
  } else if(select == 'form') {
    info.textContent = 'Заполните данные и оплатите товар:';
    backButton.classList.remove('hide');
    form.classList.remove('hide');
  }
}

box.addEventListener('click', e => {
  if(e.target.classList.contains('donate__item')) {
    donateItem(e.target)
  }
  if(e.path[1].classList.contains('donate__item')) {
    donateItem(e.path[1])
  }
})

backButton.addEventListener('click', () => {
  if(selection == 'product') {
    axios.get('/data/categories')
    .then(function (response) {
      createCategories(response.data);
    })
    .catch(function (error) {
      console.log(error);
    });
  } else if(selection == "form") {
    axios.get('/data/products/' + lastCategory)
      .then(function (response) {
        createProducts(response.data);
      })
      .catch(function (error) {
        console.log(error);
      });
  }
})

function donateItem(item) {
  if(selection == 'category') {
    const id = item.getAttribute('category-id');
    lastCategory = id;
    axios.get('/data/products/' + id)
      .then(function (response) {
        createProducts(response.data);
      })
      .catch(function (error) {
        console.log(error);
      });
  } else if(selection == 'product') {
    const id = item.getAttribute('product-id');
    axios.get('/data/product/' + id)
      .then(function (response) {
        createForm(response.data);
      })
      .catch(function (error) {
        console.log(error);
      });
  }
}

function deleteItems() {
  const donateItems = document.querySelectorAll('.donate__cards .donate__item');

  donateItems.forEach(item => {
    item.remove();
  })

  form.classList.add('hide');
}

function createProducts(array) {
  deleteItems();
  if(!array.length) {
    setSelection('product', true);
    return;
  } 
  array.forEach(item => {
      const donateItem = document.createElement('div');
      donateItem.classList.add('donate__item');
      donateItem.classList.add('donate__item-product');
      donateItem.setAttribute('product-id', item.id);
      
      const img = document.createElement('img');
      img.classList.add('donate__item-background');
      img.setAttribute('src', '/resources/images/product/' + item.background);
      
      const name = document.createElement('div');
      name.classList.add('donate__item-name');
      name.textContent = item.displayname;

      const price = document.createElement('div');
      price.classList.add('donate__item-price');
      price.textContent = item.price + "₽";

      donateItem.append(img);
      donateItem.append(name);
      donateItem.append(price);

      box.append(donateItem);
  })
  setSelection('product');
}

function createCategories(array) {
  deleteItems();
  if(!array.length) {
    setSelection('category', true);
    return;
  } 
  array.forEach(item => {
    const donateItem = document.createElement('div');
    donateItem.classList.add('donate__item');
    donateItem.setAttribute('category-id', item.id);
    
    const img = document.createElement('img');
    img.classList.add('donate__item-background');
    img.setAttribute('src', '/resources/images/category/' + item.background);
    
    const name = document.createElement('div');
    name.classList.add('donate__item-name');
    name.textContent = item.name;

    donateItem.append(img);
    donateItem.append(name);

    box.append(donateItem);
  })
  setSelection('category');
}

var rounded = function(number){
  return +number.toFixed(2);
}

function createForm(array) {
  deleteItems();

  const image = document.getElementById('form-image');
  const name = document.getElementById('form-name');
  const price = document.getElementById('form-price');
  const description = document.getElementById('form-description');

  image.setAttribute('src', '/resources/images/product/' + array.background);

  name.textContent = array.displayname;

  price.textContent = rounded((array.price - array.price * (array.discount / 100))) + "₽";

  description.innerHTML = array.description;  

  formProduct.value = array.id;

  if(!array.amounted) {
    amountItem.classList.add('hide');
  }
  
  setSelection('form');

  formBack();
}

// createForm({
//   background: '3.png',
//   displayname: 'Test',
//   price: 30,
//   discount: 50,
//   description: 'BEST PRODUCT',
//   id: 1,
// });

/* FORM */
sendButton.addEventListener('click', e => {
  if(type) {
    e.preventDefault();
    if(formUser.value === "") return;

    formButtons.classList.add('pay');
    formPay.classList.add('pay');
    backFormButton.classList.remove('hide')
    sendText.textContent = 'Оплатить';
    sendImage.setAttribute('src', '/resources/images/minecraft/spectral_arrow.png');
    type = false;

    let amount = 1;
    if(!amountItem.classList.contains('hide')) {
      if(formAmount.value <= 0) {
        amount = 1;
        formAmount.value = 1;
      } else {
        amount = formAmount.value;
      }
    }

    /* promocode and discount ajax */ 
    axios.get('/data/nickname/' + formUser.value + "/" + formProduct.value)
    .then(function (response) {
      let price = document.getElementById('form-price').textContent.slice(0, -1);
      if(response.data.status == "OK") {
        if(response.data.discount >= 1) {
         price = (price - response.data.discount) * amount;
         console.log(response.data);
         console.log(price);
        } else {
          sendText.textContent = 'У Вас уже имеется';
          priceValue.textContent = "x";
          return;
        }
      } else {
        price = price * amount;
      }
      if(promocode.value === "") {
        priceValue.textContent = price + "₽";
      } else {
        axios.get('/data/promocode/' + promocode.value).then(function (response) {
          if(response.data.status == "OK") {
            const discount = response.data.discount;
            priceValue.textContent = rounded((price - price * (discount / 100))) + "₽";

          } else {
            promocode.value = "Промокод не найден";
            priceValue.textContent = price + "₽";
          }
        }).catch(function (error) {
          console.log(error);
        });
      }
    }).catch(function (error) {
      console.log(error);
    });
  }
})

backFormButton.addEventListener('click', e => {
  e.preventDefault();
  formBack();
})

function formBack() {
  type = true;
  formButtons.classList.remove('pay');
  formPay.classList.remove('pay');
  backFormButton.classList.add('hide')
  sendText.textContent = 'Продолжить';
  sendImage.setAttribute('src', '/resources/images/minecraft/arrow.png');
}

// ONLINE

const online = document.querySelector('.about__online-value');

if(online) {
  axios.get('/online')
  .then(function (response) {
    online.textContent = response.data;
  })
  .catch(function (error) {
    console.log(error);
  });

  setInterval(() => {
    axios.get('/online')
        .then(function (response) {
          online.textContent = response.data;
        })
        .catch(function (error) {
          console.log(error);
        });
  }, 5000);
}

// SCROLL
const donate = document.querySelector('.about__button-donate');

if(donate) {
  donate.addEventListener('click', () => {
    document.querySelector('.donate__title').scrollIntoView({ behavior: 'smooth', block: 'start'});
  });
}