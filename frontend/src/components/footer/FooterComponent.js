import { Link } from "react-router-dom";
import "./footer.css";

export default function FooterComponent() {
  return (
    <>
      <div className="row px-3 footerSection">
        <div className="col-lg-3 col-md-6 my-5">
          <div>
            <img
              src="http://localhost:8000/images/Academic-crop.jpg"
              alt=""
              width="80%"
            />
          </div>
          <p className="my-4 small">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam,
            ipsum!
          </p>
          <div className="d-flex justify-content-start align-items-center">
            <Link
              to="/"
              className="py-1 px-2 rounded text-white me-2 "
            >
              <i className="fa-brands fa-facebook fa-xl socialIcon"></i>
            </Link>
            <Link
              to="/"
              className="py-1 px-2 rounded text-white me-2 "
            >
              <i className="fa-brands fa-instagram fa-xl socialIcon"></i>
            </Link>
            <Link
              to="/"
              className="py-1 px-2 rounded text-white me-2 "
            >
              <i className="fa-brands fa-twitter fa-xl socialIcon"></i>
            </Link>
            <Link
              to="/"
              className="py-1 px-2 rounded text-white me-2 "
            >
              <i className="fa-brands fa-linkedin fa-xl socialIcon"></i>
            </Link>
          </div>
        </div>
        <div className="col-lg-4 col-md-6 my-5">
          <h4 className="fw-bold">Contact Us</h4>
          <div className="my-4 small">
            <p>Email : abcdefgh@gmail.com</p>
            <p>Phone : +123456789</p>
            <p>Address : 40 Baria Sreet 133/2 New York City, United States</p>
          </div>
        </div>
        <div className="col-lg-2 col-md-6 offset-lg-2 offset-md-6 my-5">
          <h4 className="fw-bold">Navigations</h4>
          <div className="my-4 d-flex flex-column small">
            <Link
              to="/home"
              className=" text-decoration-none text-muted my-1 navigate"
            >
              Home
            </Link>
            <Link
              to="/courses"
              className=" text-decoration-none text-muted my-1 navigate"
            >
              Course
            </Link>
            <Link
              to="/blogs"
              className=" text-decoration-none text-muted my-1 navigate"
            >
              Blog
            </Link>
          </div>
        </div>
        <div className="col-md-12 text-center border-white border-top py-1">
          <span className="small">Copyright ©2024 All rights reserved</span>
        </div>
      </div>
    </>
  );
}
