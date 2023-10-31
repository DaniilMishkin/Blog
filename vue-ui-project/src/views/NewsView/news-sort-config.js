export const NEW_FIRST_SORT_OPTION = {
  id: 1,
  label: "New First",
  params: {
    sortByDate: "desc",
  },
};

export const NEWS_SORT_OPTIONS = [
  {
    id: 0,
    label: "Old First",
    params: {
      sortByDate: "asc",
    },
  },
  NEW_FIRST_SORT_OPTION,
  {
    id: 2,
    label: "More Likes",
    params: {
      sortByLikesCount: "desc",
    },
  },
  {
    id: 3,
    label: "Less Likes",
    params: {
      sortByLikesCount: "asc",
    },
  },
];
