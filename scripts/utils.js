/**
 * @author Arvy Aggabao
 * @author Giovanni Leo
 * @description this is a utility function to get the base URL of the application
 */
export const baseUrl = `${window.location.origin}/${
  window.location.pathname.split("/")[1]
}`;
