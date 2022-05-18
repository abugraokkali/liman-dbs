import RequestLecture from "@/views/RequestLecture";

export default [
  {
      path: "/requestlecture",
      name: "requestlecture",
      shownName: "Ders Açılması Talebi",
      component: RequestLecture,
      show: can('studentPermission')
    },
];