import Lectures from "@/views/Lectures";

export default [
  {
      path: "/lectures",
      name: "lectures",
      shownName: "Dersler",
      component: Lectures,
      show: can('adminPermission')
    },
];