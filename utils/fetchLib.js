/**
 * fetch library
 * @author Ravi Brunsvik
 * @license MIT
 */

// Get request
export const get = async (url, type = "text") => {
  try {
    const req = fetch(url, {
      method: "GET",
    });
    if (type === "text") return await req.text();
    if (type === "json") return await req.json();
  } catch (err) {
    console.error(err);
    throw new Error(err);
  }
};

// Post request
export const post = async (url, data) => {
  try {
    const req = fetch(url, {
      method: "POST",
      body: data,
    });
    return await req.text(); 
  } catch (err) {
    console.error(err);
  }
};

// Put request
export const put = (url, data) => {
  try {
    fetch(url, {
      method: "PUT",
      body: data,
    });
  } catch (err) {
    console.error(err);
  }
};

// Delete request
export const del = (url) => {
  try {
    fetch(url, {
      method: "DELETE",
    });
  } catch (err) {
    console.error(err);
  }
};
