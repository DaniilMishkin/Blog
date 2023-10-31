import { API } from "@/api/api";

class PostAPI extends API {
  async index(params) {
    const result = await this.axios.get(`api/posts`, { params });
    return result.data;
  }

  async store(data) {
    const result = await this.axios.post("api/posts", data);
    return result.data;
  }

  async update(postId, data) {
    const result = await this.axios.post(`api/posts/${postId}`, data);
    return result.data;
  }

  async delete(id) {
    await this.axios.delete(`api/posts/${id}`);
  }

  async toggleLike(postId) {
    await this.axios.post("api/likes", { postId: postId });
  }
}

export default new PostAPI();
