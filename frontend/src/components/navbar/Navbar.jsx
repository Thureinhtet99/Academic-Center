import { Link, useLocation, useNavigate } from "react-router-dom";
import "./navbar.css";
import { useEffect, useState } from "react";
import ProfileAvatar from "../ProfileAvatar";
import { Button } from "@mui/material";
import ProgressLoading from "../ProgressLoading";
import { useDispatch } from "react-redux";
import { userDataAction, userTokenAction } from "../../redux/action/userAction";

export default function Navbar({ progress }) {
  // useState
  const [userData, setUserData] = useState({});
  const [userToken, setUserToken] = useState("");

  // useLocation
  const location = useLocation();

  // useNavigate
  const navigate = useNavigate();

  // userDataRedux
  // const userDataRedux = useSelector((state) => state.userReducer.userData);

  // useDispatch
  const dispatch = useDispatch();

  // Log out
  function handleLogOut() {
    dispatch(userDataAction({}));
    dispatch(userTokenAction(""));
    localStorage.removeItem("userData");
    localStorage.removeItem("userToken");
    setUserToken("");
    navigate("/");
  }

  // useEffect
  useEffect(() => {
    setUserData(JSON.parse(localStorage.getItem("userData")));
    setUserToken(JSON.parse(localStorage.getItem("userToken")));
  }, []);

  return (
    <header>
      <div className="row">
        <div className="col-12 p-0">
          {progress && <ProgressLoading />}
          <nav className="navbar navbar-expand-lg bg-white shadow-sm">
            <div className="container-fluid">
              <Link className="navbar-brand" to="/">
                <img
                  src="http://localhost:8000/images/Academic-crop.jpg"
                  alt=""
                  width="40%"
                />
              </Link>
              <button
                className="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
              >
                <span className="navbar-toggler-icon"></span>
              </button>

              <div
                className="collapse navbar-collapse "
                id="navbarSupportedContent"
              >
                <ul className="navbar-nav mb-2 mb-lg-0">
                  <li className="nav-item mx-3">
                    <Link
                      className={`nav-link active pb-1 ${
                        (location.pathname === "/" ||
                          location.pathname === "/home") &&
                        "currentNavLink"
                      }  `}
                      to="/home"
                    >
                      Home
                    </Link>
                  </li>
                  <li className="nav-item mx-3">
                    <Link
                      className={`nav-link active pb-1 ${
                        (location.pathname === "/courses" ||
                          location.pathname.startsWith("/course/")) &&
                        "currentNavLink"
                      } `}
                      to="/courses"
                    >
                      Course
                    </Link>
                  </li>
                  <li className="nav-item mx-3">
                    <Link
                      className={`nav-link active pb-1 ${
                        (location.pathname === "/blogs" ||
                          location.pathname.startsWith("/blog/")) &&
                        "currentNavLink"
                      } `}
                      to="/blogs"
                    >
                      Blog
                    </Link>
                  </li>
                </ul>

                {!userToken ? (
                  <div className="ms-auto d-flex align-items-center">
                    <Link to="/login">
                      <Button
                        type="button"
                        variant="contained"
                        className="mx-2"
                      >
                        Login
                      </Button>
                    </Link>
                    <Link to="/register">
                      <Button type="button" variant="outlined" className="mx-2">
                        Sign Up
                      </Button>
                    </Link>
                  </div>
                ) : (
                  <div
                    className={`dropdown ms-auto rounded ${
                      location.pathname === "/profile" ||
                      (location.pathname.startsWith("/profile/") ||
                      location.pathname === "/setting"
                        ? "currentAuthBtn"
                        : "")
                    }`}
                  >
                    <button
                      className="btn px-3 authBtn"
                      type="button"
                      data-bs-toggle="dropdown"
                      aria-expanded="false"
                    >
                      <div className="row">
                        <div className="col d-flex justify-content-center align-items-center p-0">
                          <ProfileAvatar
                            photo={userData.profile_photo_path}
                            name={userData.name}
                            width={50}
                            height={50}
                          />
                        </div>
                        <div className="col d-flex align-items-center">
                          <small className="fs-6 fw-medium text-capitalize text-start">
                            {userData.name}
                          </small>
                        </div>
                      </div>
                    </button>
                    <ul
                      className="dropdown-menu px-0 mx-0"
                      id="mainBtnDropMenu"
                    >
                      <li>
                        <Link
                          className="dropdown-item py-0 text-capitalize"
                          to={`/profile/${userData.id}`}
                        >
                          <small>Profile</small>
                        </Link>
                      </li>
                      <li>
                        <Link className="dropdown-item py-0" to="/setting">
                          <small>Setting</small>
                        </Link>
                      </li>
                      <li>
                        <hr className="dropdown-divider" />
                      </li>
                      <li>
                        <button
                          className="dropdown-item py-0"
                          onClick={handleLogOut}
                        >
                          <small>Logout</small>
                        </button>
                      </li>
                    </ul>
                  </div>
                )}
              </div>
            </div>
          </nav>
        </div>
      </div>
    </header>
  );
}
