import { Link } from "react-router-dom";
import "./topNavigation.css"

export default function TopNavigation({ progress, singleCourse, location, linkName, blogDetail }) {
  return (
    <>
      <div className="row px-5 topNavigation">
        <div className="col-md-12 py-2">
          <Link to="/" className="text-decoration-none text-black fw-medium topNavigate">
            Home
          </Link>
          <i className="fa-solid fa-chevron-right fa-xs mx-2"></i>

          <Link
            to={`/${linkName}`}
            className="text-decoration-none text-capitalize text-muted topNavigate"
          >
            {linkName}
          </Link>
          <i className="fa-solid fa-chevron-right fa-xs mx-2"></i>

          {singleCourse
            && <Link
              to={`/course/${singleCourse.courseId}`}
              className="text-decoration-none text-muted text-capitalize placeholder-glow topNavigate"
            >
              {progress ? <span className="placeholder col-1"></span> : singleCourse.course_title}
            </Link>
          }

          {blogDetail
            && <Link
              to={`/blog/${blogDetail.blogId}`}
              className="text-decoration-none text-muted text-capitalize placeholder-glow topNavigate"
            >
              {progress ? <span className="placeholder col-1"></span> : blogDetail.blog_title}
            </Link>
          }
        </div>
      </div>
    </>
  );
}
