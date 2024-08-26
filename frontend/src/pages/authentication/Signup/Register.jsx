import * as React from "react";
import { Link, useNavigate } from "react-router-dom";
import "./register.css";
import { useEffect, useState } from "react";
import axios from "axios";
import Timeline from "@mui/lab/Timeline";
import TimelineItem from "@mui/lab/TimelineItem";
import TimelineSeparator from "@mui/lab/TimelineSeparator";
import TimelineConnector from "@mui/lab/TimelineConnector";
import TimelineContent from "@mui/lab/TimelineContent";
import TimelineDot from "@mui/lab/TimelineDot";
import LoadingButton from "@mui/lab/LoadingButton";
import { Button } from "@mui/material";
import ChevronLeftIcon from "@mui/icons-material/ChevronLeft";
import ChevronRightIcon from "@mui/icons-material/ChevronRight";
import { baseApi } from "../../../api/BaseApi";
import SnackBarComponent from "../../../components/snackBar/SnackBarComponent";

export function BasicTimeline({ currentSection }) {
  return (
    <Timeline position="alternate">
      <TimelineItem>
        <TimelineSeparator>
          <TimelineDot
            variant={currentSection > 1 ? "filled" : "outlined"}
            color="primary"
          ></TimelineDot>
          <TimelineConnector
            className={`${currentSection > 1 && "bg-primary"} stepBetween`}
          />
        </TimelineSeparator>
        <TimelineContent>Personal</TimelineContent>
      </TimelineItem>
      <TimelineItem>
        <TimelineSeparator>
          <TimelineDot
            variant={currentSection > 2 ? "filled" : "outlined"}
            color="primary"
          ></TimelineDot>
          <TimelineConnector
            className={`${currentSection > 2 && "bg-primary"} stepBetween`}
          />
        </TimelineSeparator>
        <TimelineContent>Content</TimelineContent>
      </TimelineItem>
      <TimelineItem>
        <TimelineSeparator>
          <TimelineDot
            variant={currentSection > 3 ? "filled" : "outlined"}
            color="primary"
          ></TimelineDot>
        </TimelineSeparator>
        <TimelineContent>Security</TimelineContent>
      </TimelineItem>
    </Timeline>
  );
}

export function PersonalSection({
  currentSection,
  name,
  handleName,
  nameError,
  email,
  handleEmail,
  checkEmail,
  checkEmailLoading,
  emailExist,
  emailError,
  validEmail,
  gender,
  handleGender,
  genderError,
}) {
  return (
    <>
      {currentSection === 1 && (
        <div id="personalSection">
          <div className="mb-3">
            <label htmlFor="name" className="form-label">
              Name
            </label>
            <input
              type="text"
              className="form-control mb-1"
              id="name"
              placeholder="Enter Name"
              value={name}
              onChange={handleName}
            />
            {nameError && <p className="text-danger small">Name is required</p>}
          </div>
          <div className="mb-3">
            <div className="row">
              <div className="col-6">
                <label htmlFor="email" className="form-label">
                  Email
                </label>
                <input
                  type="email"
                  className="form-control mb-1"
                  id="email"
                  aria-describedby="emailHelp"
                  placeholder="Enter Email"
                  value={email}
                  onChange={handleEmail}
                />
                {checkEmailLoading && (
                  <div
                    className="spinner-border spinner-border-sm text-primary"
                    role="status"
                  >
                    <span className="visually-hidden">Loading...</span>
                  </div>
                )}
                {checkEmail && (
                  <p className="text-danger small">Invalid email address</p>
                )}
                {emailExist && (
                  <p className="text-danger small">
                    Email is already taken
                    <i className="fa-solid fa-circle-xmark fa-lg mx-1"></i>
                  </p>
                )}
                {validEmail && (
                  <p className="text-success small">
                    Valid Email
                    <i className="fa-solid fa-circle-check fa-lg mx-1 "></i>
                  </p>
                )}
                {emailError && (
                  <p className="text-danger small">Email is required</p>
                )}
              </div>
              <div className="col-6">
                <label htmlFor="gender" className="form-label">
                  Gender
                </label>
                <select
                  id="gender"
                  className="form-select mb-1"
                  value={gender}
                  onChange={handleGender}
                >
                  <option value="">Select Gender</option>
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                </select>
                {genderError && (
                  <p className="text-danger small">Select your gender</p>
                )}
              </div>
            </div>
          </div>
        </div>
      )}
    </>
  );
}

export function ContentSection({
  currentSection,
  phone,
  setPhone,
  address,
  setAddress,
  addressList,
}) {
  return (
    <>
      {currentSection === 2 && (
        <div id="contentSection">
          <div className="mb-3">
            <label htmlFor="phone" className="form-label">
              Phone
            </label>
            <input
              type="number"
              className="form-control"
              id="phone"
              aria-describedby="emailHelp"
              value={phone}
              onChange={(event) => setPhone(event.target.value)}
            />
          </div>
          <div className="mb-3">
            <label htmlFor="address" className="form-label">
              Address
            </label>
            <input
              type="text"
              name="location"
              id="address"
              list="countryList"
              placeholder="Enter Location"
              className="form-control"
              value={address}
              onChange={(event) => setAddress(event.target.value)}
            ></input>
            <datalist id="countryList">
              {addressList.map((address) => {
                return (
                  <option
                    key={address.name}
                    value={address.name}
                    className=" text-capitalize"
                  >
                    {address.name}
                  </option>
                );
              })}
            </datalist>
          </div>
        </div>
      )}
    </>
  );
}

export function SecuritySection({
  currentSection,
  showPassword,
  password,
  handlePwdErrorText,
  handleShowPassword,
  pwdError,
  samePwdError,
  showConfirmPassword,
  confirmPassword,
  handleConfirmPwdErrorText,
  handleShowConfirmPassword,
  confirmPwdError,
}) {
  return (
    <>
      {currentSection === 3 && (
        <div id="securitySection">
          <label htmlFor="password" className="form-label">
            Password
          </label>
          <div className="input-group mb-1">
            <input
              type={showPassword ? "text" : "password"}
              className="form-control"
              id="password"
              value={password}
              onChange={handlePwdErrorText}
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
            <div className="small text-danger">Password is required</div>
          )}
          {samePwdError && (
            <div className="small text-danger">
              The two password must be the same
            </div>
          )}

          <label htmlFor="confirmPassword" className="form-label mt-3">
            Confirm password
          </label>
          <div className="input-group mb-1">
            <input
              type={showConfirmPassword ? "text" : "password"}
              className="form-control"
              id="confirmPassword"
              value={confirmPassword}
              onChange={handleConfirmPwdErrorText}
            />
            <span className="input-group-text p-1">
              <button
                type="button"
                className="btn btn-sm"
                onClick={handleShowConfirmPassword}
              >
                <i
                  className={`fa-regular ${
                    showConfirmPassword ? "fa-eye-slash" : "fa-eye"
                  } `}
                ></i>
              </button>
            </span>
          </div>
          {confirmPwdError && (
            <div className="small text-danger">
              Confirm password is required
            </div>
          )}
          {samePwdError && (
            <div className="small text-danger">
              The two password must be the same
            </div>
          )}
        </div>
      )}
    </>
  );
}

export default function Register() {
  // useNavigate
  const navigate = useNavigate();

  // useState
  const [name, setName] = useState("");
  const [nameError, setNameError] = useState(false);

  const [email, setEmail] = useState("");
  const [emailExist, setEmailExist] = useState(false);
  const [emailError, setEmailError] = useState(false);
  const [checkEmail, setCheckEmail] = useState(false);
  const [checkEmailLoading, setCheckEmailLoading] = useState(false);
  const [validEmail, setValidEmail] = useState(false);

  const [gender, setGender] = useState("");
  const [genderError, setGenderError] = useState(false);

  const [phone, setPhone] = useState("");

  const [address, setAddress] = useState("");
  const [addressList, setAddressList] = useState([]);

  const [password, setPassword] = useState("");
  const [confirmPassword, setConfirmPassword] = useState("");
  const [pwdError, setPwdError] = useState(false);
  const [confirmPwdError, setConfirmPwdError] = useState(false);
  const [samePwdError, setSamePwdError] = useState(false);
  const [showPassword, setShowPassword] = useState(false);
  const [showConfirmPassword, setShowConfirmPassword] = useState(false);

  const [currentSection, setCurrentSection] = useState(1);
  const [buttonDisable, setButtonDisable] = useState(false);
  const [snackBarOpen, setSnackBarOpen] = useState(false);

  // Fetch CountryList
  async function fetchCountryList() {
    try {
      const response = await axios.get(
        "https://gist.githubusercontent.com/almost/7748738/raw/575f851d945e2a9e6859fb2308e95a3697bea115/countries.json"
      );
      setAddressList(response.data);
    } catch (error) {
      console.error(error);
    }
  }

  // useEffect
  useEffect(() => {
    fetchCountryList();
  }, []);

  // Handle Name
  function handleName(event) {
    setName(event.target.value);
    setNameError(false);
  }

  // Handle Email
  async function handleEmail(event) {
    setEmail(event.target.value);
    const emailPattern = /\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}\b/;
    const isValidEmail = emailPattern.test(event.target.value);

    if (isValidEmail) {
      setCheckEmail(false);
      setEmailExist(false);
      setEmailError(false);
      setValidEmail(false);
      setCheckEmailLoading(true);
      try {
        await baseApi
          .post("/auth/check-user", {
            email: event.target.value,
          })
          .then((response) => {
            setCheckEmailLoading(false);
            if (response.data.checkEmail) {
              setEmailExist(true);
            } else {
              setValidEmail(true);
            }
          });
      } catch (error) {
        console.error(error);
      }
    } else {
      setCheckEmail(true);
    }
  }

  // Handle gender
  const handleGender = (event) => {
    setGenderError(false);
    setGender(event.target.value);
  };

  // Password
  const handlePwdErrorText = (event) => {
    setPwdError(false);
    setPassword(event.target.value);
  };
  const handleShowPassword = () => {
    setShowPassword(!showPassword);
  };

  // Confirm password
  const handleConfirmPwdErrorText = (event) => {
    setConfirmPwdError(false);
    setConfirmPassword(event.target.value);
  };
  const handleShowConfirmPassword = () => {
    setShowConfirmPassword(!showConfirmPassword);
  };

  // Previous button
  const handlePreviousSection = () => {
    setCurrentSection(currentSection - 1);
  };

  // Next button
  function handleNextSection() {
    if (name === "" || email === "" || gender === "") {
      setNameError(true);
      setEmailError(true);
      setGenderError(true);
      return;
    }
    setCurrentSection(currentSection + 1);
  }

  // Sign up
  async function handleSignUp(event) {
    event.preventDefault();
    if (password === "" && confirmPassword === "") {
      setPwdError(true);
      setConfirmPwdError(true);
      return;
    } else if (password !== confirmPassword) {
      setSamePwdError(true);
      return;
    }
    setButtonDisable(true);

    try {
      const response = await baseApi.post("/auth/register", {
        name,
        email,
        gender,
        phone,
        address,
        password,
        confirmPassword,
      });
      if (response.data.token) {
        setSnackBarOpen(true);
        setTimeout(() => {
          setButtonDisable(false);
          setSnackBarOpen(false);
          navigate("/login");
        }, 600);
      }
    } catch (error) {
      console.error(error);
    }
  }

  return (
    <>
      <div className="container-fluid px-0">
        <div className="row" style={{ minHeight: "100vh" }}>
          <div className="col-md-4 d-flex justify-content-center align-items-center stepsSection">
            <BasicTimeline currentSection={currentSection} />
          </div>

          <div className="col-md-8 px-5 d-flex justify-content-center align-items-center">
            <div className="container">
              <div className="text-center my-5">
                <img
                  src="http://localhost:8000/images/Academic-crop.jpg"
                  alt=""
                  width="60%"
                />
              </div>
              <form onSubmit={handleSignUp}>
                <PersonalSection
                  currentSection={currentSection}
                  name={name}
                  handleName={handleName}
                  nameError={nameError}
                  email={email}
                  handleEmail={handleEmail}
                  checkEmail={checkEmail}
                  checkEmailLoading={checkEmailLoading}
                  emailExist={emailExist}
                  emailError={emailError}
                  validEmail={validEmail}
                  gender={gender}
                  handleGender={handleGender}
                  genderError={genderError}
                />
                <ContentSection
                  currentSection={currentSection}
                  phone={phone}
                  setPhone={setPhone}
                  addres={address}
                  setAddress={setAddress}
                  addressList={addressList}
                />
                <SecuritySection
                  currentSection={currentSection}
                  showPassword={showPassword}
                  password={password}
                  handlePwdErrorText={handlePwdErrorText}
                  handleShowPassword={handleShowPassword}
                  pwdError={pwdError}
                  samePwdError={samePwdError}
                  showConfirmPassword={showConfirmPassword}
                  confirmPassword={confirmPassword}
                  handleConfirmPwdErrorText={handleConfirmPwdErrorText}
                  handleShowConfirmPassword={handleShowConfirmPassword}
                  confirmPwdError={confirmPwdError}
                />

                <div className="my-5 px-1 d-flex justify-content-between align-items-center">
                  <div>
                    <Button
                      variant="outlined"
                      startIcon={<ChevronLeftIcon />}
                      // disabled={currentSection === 1 ? true : false}
                      type="button"
                      className={currentSection === 1 ? "d-none" : ""}
                      onClick={handlePreviousSection}
                    >
                      Back
                    </Button>
                  </div>
                  <div>
                    {currentSection === 3 ? (
                      <LoadingButton
                        type="submit"
                        variant="contained"
                        loading={buttonDisable}
                        disabled={buttonDisable}
                      >
                        Sign up
                      </LoadingButton>
                    ) : (
                      <Button
                        variant="outlined"
                        endIcon={<ChevronRightIcon />}
                        type="button"
                        onClick={handleNextSection}
                      >
                        Next
                      </Button>
                    )}
                  </div>
                </div>
              </form>
              <p className="text-center my-4">
                Already have an account?{" "}
                <Link to="/login" className="fs-6 text-decoration-none">
                  Log In
                </Link>
              </p>
            </div>
          </div>
        </div>
        <SnackBarComponent
          snackBarOpen={snackBarOpen}
          snackBarMsg={"Register Success !"}
        />
      </div>
    </>
  );
}
