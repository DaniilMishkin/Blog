import { API } from "@/api/api";

class AuthApi extends API {
  async login(data) {
    return await this.axios.post("api/auth/login", data);
  }

  async logout(data) {
    return await this.axios.post("api/auth/logout", data);
  }

  async registration(data) {
    return await this.axios.post("api/auth/registration", data);
  }

  async forgotPassword(data) {
    return await this.axios.post("api/auth/forgotten-password", data);
  }

  async resetPassword(data) {
    return await this.axios.post("api/auth/reset-password", data);
  }

  async updatePassword(data) {
    return await this.axios.put("api/user/password", data);
  }

  async me() {
    const result = await this.axios.get("api/me");
    return result.data;
  }

  setCsrfCookie() {
    return this.axios.get("sanctum/csrf-cookie");
  }
}

export default new AuthApi();
