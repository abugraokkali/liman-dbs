import Admin from "@/views/Admin";

export default [
  {
      path: "/users",
      name: "users",
      shownName: "Kullanıcılar",
      component: Admin,
      show: can('adminPermission')
    },
];