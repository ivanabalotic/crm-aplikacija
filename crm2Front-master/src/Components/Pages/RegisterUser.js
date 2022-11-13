import React, { useEffect, useState } from "react";
import isEqual from "lodash.isequal";
import { useParams, useHistory } from "react-router";
import { Form, Button } from "react-bootstrap";

const RegisterUser = ({ api, setRefresh, managerId }) => {
  const history = useHistory();

  const [staffMember, setStaffMember] = useState();

  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [password_confirmation, setPasswordConfirmation] = useState("");
  const [role, setRole] = useState("sales");
  const [status, setStatus] = useState("1");

  const onSubmit = (e) => {
    e.preventDefault();
    console.log(role);
    const apiToken = window.localStorage.getItem("api_token");
    const signedInRole = window.localStorage.getItem("role");

    api
      .post(
        `/staff/register`,
        {
          name,
          email,
          password,
          password_confirmation,
          role,
          status,
          manager_id: window.localStorage.getItem("staff_id")
        },

        { headers: { token: apiToken, role: signedInRole } }
      )
      .then((res) => {
        setStaffMember(res.data);
        // console.log(contacts);
        setRefresh(true);
        alert("Staff member successfully added");
        history.push("/Dashboard");
      })
      .catch((error) => {
        const emailErr = error.response.data.message.email;
        const nameErr = error.response.data.message.name;
        const passwordErr = error.response.data.message.password;
        const roleErr = error.response.data.message.role;
        const statusErr = error.response.data.message.status;
        let message = ["", "", "", "", ""];
        if (emailErr !== undefined) {
          message[1] = "Email is " + emailErr + "\n";
        }
        if (nameErr !== undefined) {
          message[0] = "Name is " + nameErr + "\n";
        }
        if (passwordErr !== undefined) {
          message[2] = "Password is " + passwordErr + "\n";
        }
        if (roleErr !== undefined) {
          message[3] = "Role is " + roleErr + "\n";
        }
        if (statusErr !== undefined) {
          message[4] = "Status is " + statusErr + "\n";
        }
        // console.log(error.response.data.message.status);
        // const data = error.response.data;
        // data.map((poruka, i) => console.log(data[i]));
        alert(message);
      });
    e.preventDefault();
    console.log("Submit");
  };
  return (
    <div className="container">
      <h5>Register new staff member:</h5>
      <div className="form-container">
        <Form>
          <hr />
          <div className="input-container">
            <p>Name:</p>
            <Form.Control
              type="text"
              name="name"
              value={name}
              onChange={(e) => {
                setName(e.target.value);
              }}
            />
          </div>
          <div className="input-container">
            <p>Email:</p>
            <Form.Control
              type="text"
              name="email"
              value={email}
              onChange={(e) => {
                setEmail(e.target.value);
              }}
            />
          </div>
          <div className="input-container">
            <p>Password:</p>
            <Form.Control
              type="text"
              name="password"
              value={password}
              onChange={(e) => {
                setPassword(e.target.value);
              }}
            />
          </div>
          <div className="input-container">
            <p>Confirm password:</p>
            <Form.Control
              type="text"
              name="password"
              value={password_confirmation}
              onChange={(e) => {
                setPasswordConfirmation(e.target.value);
              }}
            />
          </div>
          <div className="input-container">
            <p>Role:</p>
            <Form.Control
              as="select"
              name="role"
              value={role}
              onChange={(e) => {
                setRole(e.target.value);
              }}
            >
              <option value="sales">Sales</option>
              <option value="manager">Manager</option>
            </Form.Control>
          </div>
          <div className="input-container">
            <p>Status:</p>
            <Form.Control
              as="select"
              name="status"
              value={status}
              onChange={(e) => {
                setStatus(e.target.value);
              }}
            >
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </Form.Control>
          </div>

          <div className="buttons">
            <Button type="submit" onClick={onSubmit} className="accept-button">
              Accept
            </Button>
          </div>
        </Form>
      </div>
    </div>
  );
};

export default RegisterUser;
