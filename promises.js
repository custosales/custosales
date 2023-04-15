// Promises
const testPromise = () => {
  return new Promise((resolve, reject) => {
    try {
      let a = 100;
      //throw new Error("This went wrong");
      setTimeout(() => resolve(a), 1000);
    } catch (error) {
      reject(error);
    }
  });
};

testPromise()
  .then((result) => console.log(result))
  .catch((error) => console.error(error));

const asyncTest = async () => {
  let a = 100;
  try {
    throw new Error('Test');
    await setTimeout(() => console.log(a), 1000)
  } catch(error) {
    throw new Error('This went wrong 22 ');
  }
}

let url = 'https://berg-hansen.info';

const promiseFetch = () => {
  fetch(url)
    .then(response => response.text())
    .then(text => console.log(text,"_".repeat(80)));
}

const asyncFetch = async () => {
  const request = await fetch(url);
  console.log(await request.text());
}


promiseFetch();

asyncFetch();
//promiseFetch();

// const promise1 = new Promise((resolve, reject) => {
//   resolve(1 + 5);
// })

// const promise2 = new Promise((resolve, reject) => {
//   resolve(1 + 6);
// })

// const promise3 = new Promise((resolve, reject) => {
//   resolve(1 + 7);
// })

// Promise.all([promise1, promise2, promise3]).then(result => console.log(result));