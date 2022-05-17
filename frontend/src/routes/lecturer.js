import Lecturer from "@/views/Lecturer";

export default [
  {
      path: "/lecturer",
      name: "lecturer",
      shownName: "Dersler",
      component: Lecturer,
      show: can('lecturerPermission')
    },
];