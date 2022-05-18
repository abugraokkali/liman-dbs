import Vue from "vue";
import Router from "vue-router";

// Routes
import UsersRouter from "@/routes/users.js";
import StudentRouter from "@/routes/student.js";
import LecturerRouter from "@/routes/lecturer.js";
import AddLectureRouter from "@/routes/add-lecture.js";
import RequestLectureRouter from "@/routes/request-lecture.js";

import LecturesRouter from "@/routes/lectures.js";

Vue.use(Router);

export default new Router({
  base: "",
  mode: "hash",
  routes: [
    ...UsersRouter,
    ...LecturerRouter,
    ...StudentRouter,
    ...LecturesRouter,
    ...AddLectureRouter,
    ...RequestLectureRouter,
    {
      path: "*",
      redirect: () => {
        if(can('adminPermission'))
          return 'users'
        if(can('lecturerPermission'))
          return 'lecturer'
        if(can('studentPermission'))
          return 'student'
      },
    }
  ]
});
