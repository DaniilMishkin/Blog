import { API } from "@/api/api";

class SubscriptionApi extends API {
  async toggleSubscribe(userId) {
    await this.axios.post("api/user/subscribe", { userId });
  }

  async getUserSubscriptions(userId, params) {
    const result = await this.axios.get(`api/user/${userId}/subscriptions`, {
      params,
    });
    return result.data;
  }

  async getUserSubscribers(userId, params) {
    const result = await this.axios.get(`api/user/${userId}/subscribers`, {
      params,
    });
    return result.data;
  }
}

export default new SubscriptionApi();
