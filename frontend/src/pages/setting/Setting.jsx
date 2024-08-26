import React, { useEffect, useState } from "react";
import Navbar from "../../components/navbar/Navbar";
import Box from "@mui/material/Box";
import List from "@mui/material/List";
import ListItemButton from "@mui/material/ListItemButton";
import ListItemText from "@mui/material/ListItemText";
import { Avatar, TextField } from "@mui/material";
import FileUploadIcon from "@mui/icons-material/FileUpload";
import LoadingButton from "@mui/lab/LoadingButton";
import "./setting.css";
import axios from "axios";
import SnackBarComponent from "../../components/snackBar/SnackBarComponent";
import { baseApi } from "../../api/BaseApi";

const ProfileSection = ({
  progress,
  setProgress,
  userData,
  setSnackBarOpen,
}) => {
  const [countryList, setCountryList] = useState([]);
  const [selectedImage, setSelectedImage] = useState(null);
  const [imageSelected, setImageSelected] = useState(false);
  const [nameInput, setNameInput] = useState("");
  const [nameError, setNameError] = useState(false);
  const [emailInput, setEmailInput] = useState("");
  const [bioInput, setBioInput] = useState("");
  const [genderInput, setGenderInput] = useState("");
  const [phoneInput, setPhoneInput] = useState("");
  const [country, setCountry] = useState("");

  useEffect(() => {
    axios
      .get(
        "https://gist.githubusercontent.com/almost/7748738/raw/575f851d945e2a9e6859fb2308e95a3697bea115/countries.json"
      )
      .then((res) => setCountryList(res.data))
      .catch((error) => console.error(error));

    if (userData) {
      setNameInput(userData.name || "");
      setEmailInput(userData.email || "");
      setBioInput(userData.about || "");
      setGenderInput(userData.gender || "");
      setPhoneInput(userData.phone || "");
      setCountry(userData.location || "");
    }
  }, [userData]);

  const handleFormSubmit = (event) => {
    event.preventDefault();
    if (!nameInput) {
      setNameError(true);
      setProgress(false);
      return;
    }

    setProgress(true);
    axios
      .post(
        "http://localhost:8000/api/profile/update",
        {
          userId: userData.id,
          userName: nameInput,
          email: userData.email,
          image: selectedImage,
          phone: phoneInput,
          gender: genderInput,
          about: bioInput,
          location: country,
        },
        {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        }
      )
      .then((res) => {
        localStorage.setItem("userData", JSON.stringify(res.data.users));
        setSnackBarOpen(true);
        setTimeout(() => {
          setSnackBarOpen(false);
        }, 3000);
      })
      .catch((error) => {
        console.error(error);
      })
      .finally(() => setProgress(false));
  };

  const handleImgChange = (event) => {
    const file = event.target.files[0];
    if (file) {
      setSelectedImage(file);
      setImageSelected(true);

      const reader = new FileReader();
      reader.onload = () => {
        const imgPreview = document.getElementById("img-preview");
        imgPreview.src = reader.result;
      };
      reader.readAsDataURL(file);
    }
  };

  const handleNameChange = (event) => {
    setNameError(false);
    setNameInput(event.target.value);
  };

  const handleBioChange = (event) => {
    setBioInput(event.target.value);
  };

  const handleGenderChange = (event) => {
    setGenderInput(event.target.value);
  };

  const handlePhoneInput = (event) => {
    setPhoneInput(event.target.value);
  };

  const handleCountryInput = (event) => {
    setCountry(event.target.value);
  };

  const isGooglePhoto =
    userData.profile_photo_path &&
    userData.profile_photo_path.startsWith("http");

  return (
    <div
      className="row animate__animated animate__fadeInUp"
      id="profileSection"
    >
      <div className="col-12 d-flex justify-content-center">
        <div className="text-center">
          <Avatar
            src={
              isGooglePhoto
                ? userData.profile_photo_path
                : `http://localhost:8000/storage/${userData.profile_photo_path}`
            }
            sx={{
              width: 150,
              height: 150,
              marginBottom: "1rem",
            }}
            variant="rounded"
            style={{ display: imageSelected ? "none" : "block" }}
          />

          <img
            id="img-preview"
            src={isGooglePhoto ? userData.profile_photo_path : ""}
            alt=""
            className="border rounded object-fit-cover"
            style={{
              width: "180px",
              height: "180px",
              marginBottom: "10px",
              display: imageSelected ? "block" : "none",
            }}
          />
          <div className="image-upload">
            <label htmlFor="file-input" className="border rounded imgUpload">
              <FileUploadIcon />
            </label>
            <input id="file-input" type="file" onChange={handleImgChange} />
          </div>
        </div>
      </div>
      <div className="col-12 mb-4">
        <form onSubmit={handleFormSubmit} className="needs-validation">
          <label htmlFor="name" className="form-label">
            <b>Name</b>
          </label>
          <input
            type="text"
            id="name"
            className={`form-control ${nameError && "is-invalid"}`}
            placeholder="Name"
            value={nameInput}
            onChange={handleNameChange}
            required
          />
          {nameError && (
            <div className="text-danger small">
              <small>Name is required</small>
            </div>
          )}

          <label htmlFor="email" className="form-label mt-4">
            <b>Email</b>
          </label>
          <input
            disabled
            type="email"
            id="email"
            className="form-control"
            placeholder="Email"
            value={emailInput}
          />
          <div className="row my-4">
            <div className="col-6">
              <label htmlFor="bio" className="form-label">
                <b>Bio</b>
              </label>
              <textarea
                className="form-control"
                id="bio"
                placeholder="Enter Bio"
                value={bioInput}
                cols="30"
                rows="7"
                onChange={handleBioChange}
              ></textarea>
            </div>
            <div className="col-6">
              <label htmlFor="gender" className="form-label">
                <b>Gender</b>
              </label>
              <select
                className="form-select"
                id="gender"
                value={genderInput}
                onChange={handleGenderChange}
              >
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>
            </div>
          </div>

          <div className="row my-4">
            <div className="col-6">
              <label htmlFor="phone" className="form-label">
                <b>Phone</b>
              </label>
              <input
                type="number"
                className="form-control"
                id="phone"
                value={phoneInput}
                placeholder="Phone"
                onChange={handlePhoneInput}
              />
            </div>
            <div className="col-6">
              <label htmlFor="location" className="form-label">
                <b>Location</b>
              </label>
              <input
                type="text"
                list="countryLists"
                className="form-control"
                id="location"
                value={country}
                placeholder="Country"
                onChange={handleCountryInput}
              />
              <datalist id="countryLists">
                {countryList.map((country, index) => (
                  <option
                    key={index}
                    value={country.name}
                    className="text-capitalize"
                  >
                    {country.name}
                  </option>
                ))}
              </datalist>
            </div>
          </div>
          <div className="text-end my-4">
            <LoadingButton
              type="submit"
              loading={progress}
              variant="contained"
              className="my-3"
            >
              Submit
            </LoadingButton>
          </div>
        </form>
      </div>
    </div>
  );
};

const SocialSection = ({
  progress,
  setProgress,
  userData,
  setSnackBarOpen,
}) => {
  const [githubLink, setGithubLink] = useState(userData.github_link || "");
  const [facebookLink, setFacebookLink] = useState(
    userData.facebook_link || ""
  );
  const [linkedinLink, setLinkedinLink] = useState(
    userData.linkedin_link || ""
  );
  const [isGitHubValid, setIsGithubValid] = useState(true);
  const [isFacebookValid, setIsFacebookValid] = useState(true);
  const [isLinkedInValid, setIsLinkedInValid] = useState(true);

  useEffect(() => {
    setGithubLink(userData.github_link || "");
    setFacebookLink(userData.facebook_link || "");
    setLinkedinLink(userData.linkedin_link || "");
  }, [userData]);

  const validateLinks = () => {
    setIsGithubValid(isValidGithubLink(githubLink));
    setIsFacebookValid(isValidFacebookLink(facebookLink));
    setIsLinkedInValid(isValidLinkedinLink(linkedinLink));
  };

  useEffect(() => {
    validateLinks();
  }, [githubLink, facebookLink, linkedinLink]);

  const isValidFacebookLink = (link) => {
    const facebookRegex = /^(https?:\/\/)?(www\.)?facebook.com\/.+$/;
    return facebookRegex.test(link);
  };

  const isValidGithubLink = (link) => {
    const githubRegex = /^(https?:\/\/)?(www\.)?github.com\/.+$/;
    return githubRegex.test(link);
  };

  const isValidLinkedinLink = (link) => {
    const linkedinRegex = /^(https?:\/\/)?(www\.)?linkedin.com\/.+$/;
    return linkedinRegex.test(link);
  };

  const handleSocialFormSubmit = async (event) => {
    event.preventDefault();
    setProgress(true);
    try {
      const res = await baseApi.post("/profile/update-social-links", {
        userId: userData.id,
        email: userData.email,
        github: githubLink,
        facebook: facebookLink,
        linkedin: linkedinLink,
      });
      localStorage.setItem("userData", JSON.stringify(res.data.socials));
      setSnackBarOpen(true);
      setTimeout(() => {
        setSnackBarOpen(false);
      }, 3000);
    } catch (error) {
      console.error(error);
    } finally {
      setProgress(false);
    }
  };

  return (
    <div
      className="row animate__animated animate__fadeInUp"
      id="profileSection"
    >
      <div className="col-12 mb-4 pe-5">
        <form onSubmit={handleSocialFormSubmit}>
          <TextField
            fullWidth
            sx={{ mx: 2 }}
            className="mt-4"
            variant="standard"
            label="Github Link"
            value={githubLink}
            onChange={(e) => setGithubLink(e.target.value)}
            error={!isGitHubValid}
            helperText={!isGitHubValid && "This is not a valid Github link."}
          />
          <TextField
            fullWidth
            sx={{ mx: 2 }}
            className="mt-4"
            variant="standard"
            label="Facebook Link"
            value={facebookLink}
            onChange={(e) => setFacebookLink(e.target.value)}
            error={!isFacebookValid}
            helperText={
              !isFacebookValid && "This is not a valid Facebook link."
            }
          />
          <TextField
            fullWidth
            sx={{ mx: 2 }}
            className="mt-4"
            variant="standard"
            label="LinkedIn Link"
            value={linkedinLink}
            onChange={(e) => setLinkedinLink(e.target.value)}
            error={!isLinkedInValid}
            helperText={
              !isLinkedInValid && "This is not a valid LinkedIn link."
            }
          />
          <div className="text-end my-4">
            <LoadingButton
              disabled={!isGitHubValid || !isFacebookValid || !isLinkedInValid}
              type="submit"
              loading={progress}
              variant="contained"
              className="my-3"
            >
              Submit
            </LoadingButton>
          </div>
        </form>
      </div>
    </div>
  );
};

const Setting = () => {
  const [progress, setProgress] = useState(false);
  const [userData, setUserData] = useState({});
  const [selectedIndex, setSelectedIndex] = useState(1);
  const [snackBarOpen, setSnackBarOpen] = useState(false);

  const handleListItemClick = (event, index) => {
    setSelectedIndex(index);
  };

  // useEffect
  useEffect(() => {
    const storedUserData = JSON.parse(localStorage.getItem("userData"));
    if (storedUserData) {
      setUserData(storedUserData);
    }
  }, []);

  return (
    <>
      <Navbar progress={progress} />

      <main>
        <div className="row">
          <h2 className="text-center fw-bold mt-4 mb-5">Account Setting</h2>
          <div className="col-10 offset-1">
            <div className="row py-4 shadow  rounded">
              <div className="col-3 border-end">
                <Box
                  sx={{
                    width: "100%",
                    maxWidth: 360,
                  }}
                >
                  <List component="nav">
                    <ListItemButton
                      selected={selectedIndex === 1}
                      onClick={(event) => handleListItemClick(event, 1)}
                    >
                      <a
                        href="#profileSection"
                        className="text-decoration-none text-black"
                      >
                        <ListItemText primary="My Profile" />
                      </a>
                    </ListItemButton>
                    <ListItemButton
                      selected={selectedIndex === 2}
                      onClick={(event) => handleListItemClick(event, 2)}
                    >
                      <a
                        href="#socialSection"
                        className="text-decoration-none text-black"
                      >
                        <ListItemText primary="Socials" />
                      </a>
                    </ListItemButton>
                  </List>
                </Box>
              </div>
              <div className="col-9">
                {selectedIndex === 1 ? (
                  <ProfileSection
                    progress={progress}
                    setProgress={setProgress}
                    userData={userData}
                    snackBarOpen={snackBarOpen}
                    setSnackBarOpen={setSnackBarOpen}
                  />
                ) : selectedIndex === 2 ? (
                  <SocialSection
                    progress={progress}
                    setProgress={setProgress}
                    userData={userData}
                    setSnackBarOpen={setSnackBarOpen}
                  />
                ) : null}
              </div>
            </div>
          </div>
        </div>
      </main>

      <SnackBarComponent
        snackBarOpen={snackBarOpen}
        snackBarMsg={"Profile Updated"}
      />
    </>
  );
};

export default Setting;
