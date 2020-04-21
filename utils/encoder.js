export const encodeElement = (element) => {
  return encodeURIComponent(document.getElementById(element).value);
}