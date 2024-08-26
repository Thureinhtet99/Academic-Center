import { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import { Chip, Divider } from "@mui/material";
import LoadingButton from "@mui/lab/LoadingButton";
import SnackBarComponent from "../../components/snackBar/SnackBarComponent";
import { jwtDecode } from "jwt-decode";
import { GoogleLogin } from "@react-oauth/google";
import { baseApi } from "../../api/BaseApi";
import { useDispatch } from "react-redux";
import { userDataAction, userTokenAction } from "../../redux/action/userAction";

const Login = () => {
  // useState
  const [email, setEmail] = useState("");
  const [emailError, setEmailError] = useState(false);

  const [password, setPassword] = useState("");
  const [showPassword, setShowPassword] = useState(false);
  const [pwdError, setPwdError] = useState(false);

  const [error, setError] = useState(false);

  const [loading, setLoading] = useState(false);

  const [snackBarOpen, setSnackBarOpen] = useState(false);

  // useNavigate
  const navigate = useNavigate();

  // useDispatch
  const dispatch = useDispatch();

  // Handle show pwd
  function handleShowPassword() {
    setShowPassword(!showPassword);
  }

  // Form submit
  async function handleFormSubmit(event) {
    event.preventDefault();
    if (email === "" || password === "") {
      setEmailError(true);
      setPwdError(true);
      return;
    }
    setLoading(true);
    setError(false);

    try {
      const response = await baseApi.post("/auth/login", {
        email,
        password,
      });
      if (response.data.token) {
        dispatch(userDataAction(response.data.users));
        dispatch(userTokenAction(response.data.token));
        localStorage.setItem("userData", JSON.stringify(response.data.users));
        localStorage.setItem("userToken", JSON.stringify(response.data.token));
        setLoading(false);
        setSnackBarOpen(true);
        setTimeout(() => {
          navigate("/");
        }, 700);
      } else {
        setError("Invalid email or password");
        setLoading(false);
      }
    } catch (error) {
      setError("Login failed, please try again");
      setLoading(false);
    }
  }

  // Google login success
  async function handleGoogleLoginSuccess(credentialResponse) {
    setLoading(true);
    try {
      const decodedCredential = jwtDecode(credentialResponse.credential);

      const response = await baseApi.post("/auth/google-login", {
        email: decodedCredential.email,
        name: decodedCredential.name,
        photo: decodedCredential.picture,
      });

      if (response.data.token) {
        dispatch(userDataAction(response.data.users));
        dispatch(userTokenAction(response.data.token));
        localStorage.setItem("userData", JSON.stringify(response.data.users));
        localStorage.setItem("userToken", JSON.stringify(response.data.token));
        setSnackBarOpen(true);
        setTimeout(() => {
          navigate("/");
        }, 700);
        setLoading(false);
      }
    } catch (error) {
      console.error(error);
    }
  }

  // Google login error
  function handleGoogleLoginError(error) {
    console.error(error);
  }

  return (
    <>
      <div className="row">
        <div
          className="col-md-6 offset-md-3 d-flex justify-content-center align-items-center shadow"
          style={{ minHeight: "100vh" }}
        >
          <div>
            <div className="text-center my-5">
              <img
                src="http://localhost:8000/images/Academic-crop.jpg"
                alt=""
                width="100%"
              />
            </div>
            <form onSubmit={handleFormSubmit}>
              <div className="mb-3">
                <input
                  type="email"
                  className="form-control"
                  id="email"
                  aria-describedby="emailHelp"
                  placeholder="Email"
                  value={email}
                  onChange={(event) => {
                    setEmail(event.target.value);
                    setError(false);
                    setEmailError(false);
                  }}
                />
                {emailError && (
                  <p className="small text-danger">Enter your email</p>
                )}
              </div>

              <div className="input-group">
                <input
                  type={showPassword ? "text" : "password"}
                  className="form-control"
                  placeholder="Password"
                  value={password}
                  onChange={(event) => {
                    setPassword(event.target.value);
                    setError(false);
                    setPwdError(false);
                  }}
                />
                <span className="input-group-text p-1">
                  <button
                    type="button"
                    className="btn btn-sm"
                    onClick={handleShowPassword}
                  >
                    <i
                      className={`fa-regular ${
                        showPassword ? "fa-eye-slash" : "fa-eye"
                      } `}
                    ></i>
                  </button>
                </span>
              </div>
              {pwdError && (
                <p className="small text-danger">Enter your password</p>
              )}

              {error && (
                <p id="emailHelp" className="small text-danger">
                  {error}
                </p>
              )}

              <div className="my-3 form-check d-flex justify-content-between align-items-center">
                <div>
                  <input
                    type="checkbox"
                    className="form-check-input"
                    id="exampleCheck1"
                  />
                  <label className="form-check-label" htmlFor="exampleCheck1">
                    Remember me
                  </label>
                </div>
                <div>
                  <Link
                    to=""
                    className="form-check-label text-decoration-none"
                    htmlFor="exampleCheck1"
                  >
                    Forgot password?
                  </Link>
                </div>
              </div>

              <div className="text-center my-4">
                <LoadingButton
                  type="submit"
                  variant="contained"
                  disabled={loading}
                  loading={loading}
                >
                  Login
                </LoadingButton>
              </div>
            </form>
            <p className="text-center my-4">
              Don't have an account?{" "}
              <Link to="/register" className="fs-6 text-decoration-none">
                Sign Up
              </Link>
            </p>

            <Divider>
              <Chip label="or" size="small" />
            </Divider>

            <div className="d-flex justify-content-center align-items-center my-4">
              <button
                type="button"
                className="btn rounded-circle px-2 mx-2 shadow"
              >
                <i className="fa-brands fa-facebook fa-lg" />
              </button>
              <GoogleLogin
                onSuccess={handleGoogleLoginSuccess}
                onError={handleGoogleLoginError}
              />
            </div>
          </div>
        </div>
      </div>
      <SnackBarComponent
        snackBarOpen={snackBarOpen}
        snackBarMsg={"Login Success !"}
      />
    </>
  );
};

export default Login;
