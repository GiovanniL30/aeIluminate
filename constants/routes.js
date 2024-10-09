import { html as accountHTML } from "../scripts/routes/account.js";
import { html as dashboardHTML } from "../scripts/routes/dashboard.js";

export const routes = {
  "/": {
    label: "Dashboard",
    content: async () => await dashboardHTML(),
    icon: "N/A",
  },
  "/accounts": {
    label: "Accounts",
    content: async () => await accountHTML(),
    icon: "N/A",
  },
};
