import { API } from "@/api/api";

class UsersApi extends API {
  async index(params) {
    const result = await this.axios.get("api/users", { params });
    return result.data;
  }

  async show(userId) {
    const result = await this.axios.get(`api/users/${userId}`);
    return result.data;
  }

  async update(userId, data) {
    const result = await this.axios.post(`api/users/${userId}`, data);
    return result.data;
  }
}

export default new UsersApi();
