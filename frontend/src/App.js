import { Route, Routes } from "react-router-dom";
import "./App.css";
import Home from "./pages/home/Home";
import Course from "./pages/courses/Course";
import Login from "./pages/authentication/Login";
import Register from "./pages/authentication/Signup/Register";
import CourseDetails from "./pages/courseDetails/CourseDetails";
import Blog from "./pages/blogs/Blog";
import Lesson from "./pages/lessons/Lesson";
import Profile from "./pages/profile/Profile";
import Setting from "./pages/setting/Setting";
import Instructor from "./pages/instructor/Instructor";
import BlogDetails from "./pages/blogDetails/BlogDetails";

export default function App() {
  return (
    <>
      <div className="container-fluid">
        <Routes>
          {/* Auth */}
          <Route path="/login" element={<Login />}></Route>
          <Route path="/register" element={<Register />}></Route>

          {/* Main */}
          <Route path="/" element={<Home />}></Route>
          <Route path="/home" element={<Home />}></Route>
          <Route path="/courses" element={<Course />}></Route>
          <Route path="/course/:courseId" element={<CourseDetails />}></Route>
          <Route
            path="/course/:courseId/lesson/:lessonId"
            element={<Lesson />}
          ></Route>
          <Route path="/blogs" element={<Blog />}></Route>
          <Route path="/blog/:blogId" element={<BlogDetails />}></Route>
          <Route
            path="/instructor/:instructorId"
            element={<Instructor />}
          ></Route>
          <Route path="/profile/:userId" element={<Profile />}></Route>
          <Route path="/setting" element={<Setting />}></Route>
        </Routes>
      </div>
    </>
  );
}
