import { Link } from "react-router-dom";
import "./courseCard.css";
import { Button } from "@mui/material";
import { baseApi } from "../../api/BaseApi";
import { useContext } from "react";
import { UserDataContext } from "../../context/UserContext";

export default function CourseCardComponent({ course, lessonCounts, width }) {
  // useContext
  const userData = useContext(UserDataContext);

  // Create trend course
  async function handleTrendCourse() {
    try {
      await baseApi.post("/action-log/store", {
        userId: userData.id,
        courseId: course.courseId,
      });
    } catch (error) {
      console.error(error);
    }
  }

  return (
    <>
      <Link
        to={`/course/${course.courseId}`}
        className=" text-decoration-none"
        onClick={() => handleTrendCourse()}
      >
        <div
          className="card animate__animated animate__fadeIn"
          style={{ width: `${width}rem` }}
        >
          <img
            src={
              course.course_image
                ? `http://localhost:8000/storage/${course.course_image}`
                : "http://localhost:8000/images/default-image.png"
            }
            className="card-img-top object-fit-cover position-relative"
            alt={course.course_title}
          />
          <span className="position-absolute text-white px-2 bg-primary small text-capitalize categoryTag">
            {course.category_name && course.category_name}
          </span>
          <div className="card-body text-start px-3">
            <h4 className="card-title fw-bold text-capitalize">
              {course.course_title}
            </h4>
            <p className="card-text text-capitalize">
              {course.author_name && (
                <i className="fa-solid fa-user-graduate me-2"></i>
              )}

              {course.author_name}
            </p>

            {course.course_description ? (
              <p className="card-text text-muted small">
                {course.course_description.length > 91
                  ? course.course_description.slice(0, 90) + "....."
                  : course.course_description}
              </p>
            ) : lessonCounts ? (
              <p className="card-text my-4 text-muted small">
                Total Lessons:{" "}
                <span className="text-black">{lessonCounts}</span>
              </p>
            ) : (
              <p className="card-text my-4 text-muted small">
                Total Lessons:{" "}
                <span className="text-black">{lessonCounts}</span>
              </p>
            )}

            <hr />
            {course.course_price ? (
              <div className="d-flex justify-content-between align-items-center">
                <div>
                  <span className="fw-medium text-muted small">
                    <i className="fa-solid fa-users fa-lg text-primary me-2"></i>
                    {course.userCount} student
                  </span>
                </div>
                <span className="fw-medium text-muted small">
                  <i className="fa-solid fa-dollar-sign fa-lg text-primary me-2"></i>
                  {course.course_price} Ks
                </span>
              </div>
            ) : (
              <Button fullWidth size="small" variant="contained">
                Continue
              </Button>
            )}
          </div>
        </div>
      </Link>
    </>
  );
}
