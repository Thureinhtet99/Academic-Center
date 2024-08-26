import { createContext } from "react";

export const UserDataContext = createContext(
  JSON.parse(localStorage.getItem("userData"))
);

export const UserTokenContext = createContext(
  JSON.parse(localStorage.getItem("userToken"))
);
