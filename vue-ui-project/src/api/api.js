import axios from "axios";
import camelCase from "lodash/camelCase";
import { convertObjectKeys } from "@/api/apiHelpers";

export class API {
  constructor() {
    this.axios = axios.create({
      baseURL: process.env.VUE_APP_API_URL,
      withCredentials: true,
    });

    this.axios.interceptors.request.use((config) => {
      config.headers["X-Socket-ID"] = window.Echo.socketId();

      config.params = convertObjectKeys(config.params);

      if (config.data instanceof FormData) {
        return config;
      }

      config.data = convertObjectKeys(config.data);

      return config;
    });

    this.axios.interceptors.response.use((response) => {
      return convertObjectKeys(response, camelCase);
    });
  }
}
