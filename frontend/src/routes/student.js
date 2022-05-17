import Student from "@/views/Student";

export default [
  {
      path: "/student",
      name: "student",
      shownName: "Dersler",
      component: Student,
      show: can('studentPermission')
    },
];