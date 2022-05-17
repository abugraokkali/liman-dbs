import AddLecture from "@/views/AddLecture";

export default [
  {
      path: "/addlecture",
      name: "addlecture",
      shownName: "Ders Oluştur",
      component: AddLecture,
      show: can('adminPermission')
    },
];