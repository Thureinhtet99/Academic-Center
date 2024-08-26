import { Link } from "react-router-dom";
import "./latestCourse.css";

export default function LatestCourse({ progress, latestCourseList }) {
  return (
    <>
      <div className="row my-5">
        <h3 className="fw-bold mb-3">Latest Courses</h3>

        {progress ? (
          <div className="text-center my-5">
            <div className="spinner-border" role="status">
              <span className="visually-hidden">Loading...</span>
            </div>
          </div>
        ) : (
          latestCourseList.map((course) => {
            return (
              <div
                className="col-lg-12 col-md-6 p-2  border-bottom latestCourseCard"
                key={course.id}
              >
                <Link
                  to={`/course/${course.id}`}
                  className="text-decoration-none text-black d-flex align-items-center"
                >
                  <div>
                    <img
                      src={
                        course.course_image
                          ? `http://localhost:8000/storage/${course.course_image}`
                          : "http://localhost:8000/images/default-image.png"
                      }
                      alt=""
                      className="object-fit-cover rounded"
                      style={{ width: "6rem", height: "5rem" }}
                    />
                  </div>
                  <div className="ms-3">
                    <h5 className="font-medium text-capitalize">
                      {course.course_title}
                    </h5>
                    <span className="small text-primary">
                      {course.course_price === 0 ? "Free" : course.course_price}
                      <span className="mx-1">Ks</span>
                    </span>
                  </div>
                </Link>
              </div>
            );
          })
        )}
      </div>
    </>
  );
}
