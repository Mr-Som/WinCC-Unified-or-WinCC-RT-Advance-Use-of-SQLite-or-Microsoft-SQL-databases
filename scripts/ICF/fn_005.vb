Sub FN_005()

    On Error Resume Next ' Enable error handling

    Dim objConn, objRS, sqlQuery, checkQuery
    Dim dbPath, strError, logFile, fso, file, timeStamp
    Dim test_id, full_brk_applied, full_brk_rel_in_iso
    Dim coach(1 To 24), ps_end_col1(1 To 24), ps_end_col2(1 To 24), ps_non_col1(1 To 24), ps_non_col2(1 To 24)
    Dim i

    ' SQLite database path
    dbPath = HmiRuntime.SmartTags("DB_PATH")
    logFile = HmiRuntime.SmartTags("LOG_PATH")

    ' Get SmartTag values
    test_id = HmiRuntime.SmartTags("NEW_RTR_TEST_ID")

    ' Convert 1/0 to Yes/No for FULL_BRK_APPLIED
    If HmiRuntime.SmartTags("FULL_BRK_APPLIED") = 2 Then
        full_brk_applied = "Applied"
    Else
        full_brk_applied = "Not Applied"
    End If

    ' Convert 1/0 to Yes/No for FULL_BRK_REL_IN_ISO
    If HmiRuntime.SmartTags("FULL_BRK_REL_IN_ISO") = 2 Then
        full_brk_rel_in_iso = "Yes"
    Else
        full_brk_rel_in_iso = "No"
    End If

    ' Get coach values
    For i = 1 To 24
        coach(i) = HmiRuntime.SmartTags("COACH" & Format(i, "00"))
    Next

    ' Get pressure values
    For i = 1 To 24
        ps_end_col1(i) = HmiRuntime.SmartTags("PS_END_COL1_" & Format(i, "00"))
        ps_end_col2(i) = HmiRuntime.SmartTags("PS_END_COL2_" & Format(i, "00"))
        ps_non_col1(i) = HmiRuntime.SmartTags("PS_NON_COL1_" & Format(i, "00"))
        ps_non_col2(i) = HmiRuntime.SmartTags("PS_NON_COL2_" & Format(i, "00"))
    Next

    ' Create ADODB connection object
    Set objConn = CreateObject("ADODB.Connection")
    objConn.Open "Driver={SQLite3 ODBC Driver};Database=" & dbPath & ";"

    ' Check if ID exists
    checkQuery = "SELECT COUNT(*) AS cnt FROM tbl_icf_03 WHERE id = " & test_id
    Set objRS = objConn.Execute(checkQuery)

    If objRS("cnt") > 0 Then
        ' If exists → UPDATE
        sqlQuery = "UPDATE tbl_icf_03 SET " & _
                   "full_brk_applied='" & full_brk_applied & "'," & _
                   "full_brk_rel_in_iso='" & full_brk_rel_in_iso & "'," & _
                   "coach01='" & coach(1) & "'," & _
                   "coach02='" & coach(2) & "'," & _
                   "coach03='" & coach(3) & "'," & _
                   "coach04='" & coach(4) & "'," & _
                   "coach05='" & coach(5) & "'," & _
                   "coach06='" & coach(6) & "'," & _
                   "coach07='" & coach(7) & "'," & _
                   "coach08='" & coach(8) & "'," & _
                   "coach09='" & coach(9) & "'," & _
                   "coach10='" & coach(10) & "'," & _
                   "coach11='" & coach(11) & "'," & _
                   "coach12='" & coach(12) & "'," & _
                   "coach13='" & coach(13) & "'," & _
                   "coach14='" & coach(14) & "'," & _
                   "coach15='" & coach(15) & "'," & _
                   "coach16='" & coach(16) & "'," & _
                   "coach17='" & coach(17) & "'," & _
                   "coach18='" & coach(18) & "'," & _
                   "coach19='" & coach(19) & "'," & _
                   "coach20='" & coach(20) & "'," & _
                   "coach21='" & coach(21) & "'," & _
                   "coach22='" & coach(22) & "'," & _
                   "coach23='" & coach(23) & "'," & _
                   "coach24='" & coach(24) & "'," & _
                   "ps_end_col1_01='" & ps_end_col1(1) & "'," & _
                   "ps_end_col1_02='" & ps_end_col1(2) & "'," & _
                   "ps_end_col1_03='" & ps_end_col1(3) & "'," & _
                   "ps_end_col1_04='" & ps_end_col1(4) & "'," & _
                   "ps_end_col1_05='" & ps_end_col1(5) & "'," & _
                   "ps_end_col1_06='" & ps_end_col1(6) & "'," & _
                   "ps_end_col1_07='" & ps_end_col1(7) & "'," & _
                   "ps_end_col1_08='" & ps_end_col1(8) & "'," & _
                   "ps_end_col1_09='" & ps_end_col1(9) & "'," & _
                   "ps_end_col1_10='" & ps_end_col1(10) & "'," & _
                   "ps_end_col1_11='" & ps_end_col1(11) & "'," & _
                   "ps_end_col1_12='" & ps_end_col1(12) & "'," & _
                   "ps_end_col1_13='" & ps_end_col1(13) & "'," & _
                   "ps_end_col1_14='" & ps_end_col1(14) & "'," & _
                   "ps_end_col1_15='" & ps_end_col1(15) & "'," & _
                   "ps_end_col1_16='" & ps_end_col1(16) & "'," & _
                   "ps_end_col1_17='" & ps_end_col1(17) & "'," & _
                   "ps_end_col1_18='" & ps_end_col1(18) & "'," & _
                   "ps_end_col1_19='" & ps_end_col1(19) & "'," & _
                   "ps_end_col1_20='" & ps_end_col1(20) & "'," & _
                   "ps_end_col1_21='" & ps_end_col1(21) & "'," & _
                   "ps_end_col1_22='" & ps_end_col1(22) & "'," & _
                   "ps_end_col1_23='" & ps_end_col1(23) & "'," & _
                   "ps_end_col1_24='" & ps_end_col1(24) & "'," & _
                   "ps_end_col2_01='" & ps_end_col2(1) & "'," & _
                   "ps_end_col2_02='" & ps_end_col2(2) & "'," & _
                   "ps_end_col2_03='" & ps_end_col2(3) & "'," & _
                   "ps_end_col2_04='" & ps_end_col2(4) & "'," & _
                   "ps_end_col2_05='" & ps_end_col2(5) & "'," & _
                   "ps_end_col2_06='" & ps_end_col2(6) & "'," & _
                   "ps_end_col2_07='" & ps_end_col2(7) & "'," & _
                   "ps_end_col2_08='" & ps_end_col2(8) & "'," & _
                   "ps_end_col2_09='" & ps_end_col2(9) & "'," & _
                   "ps_end_col2_10='" & ps_end_col2(10) & "'," & _
                   "ps_end_col2_11='" & ps_end_col2(11) & "'," & _
                   "ps_end_col2_12='" & ps_end_col2(12) & "'," & _
                   "ps_end_col2_13='" & ps_end_col2(13) & "'," & _
                   "ps_end_col2_14='" & ps_end_col2(14) & "'," & _
                   "ps_end_col2_15='" & ps_end_col2(15) & "'," & _
                   "ps_end_col2_16='" & ps_end_col2(16) & "'," & _
                   "ps_end_col2_17='" & ps_end_col2(17) & "'," & _
                   "ps_end_col2_18='" & ps_end_col2(18) & "'," & _
                   "ps_end_col2_19='" & ps_end_col2(19) & "'," & _
                   "ps_end_col2_20='" & ps_end_col2(20) & "'," & _
                   "ps_end_col2_21='" & ps_end_col2(21) & "'," & _
                   "ps_end_col2_22='" & ps_end_col2(22) & "'," & _
                   "ps_end_col2_23='" & ps_end_col2(23) & "'," & _
                   "ps_end_col2_24='" & ps_end_col2(24) & "'," & _
                   "ps_non_col1_01='" & ps_non_col1(1) & "'," & _
                   "ps_non_col1_02='" & ps_non_col1(2) & "'," & _
                   "ps_non_col1_03='" & ps_non_col1(3) & "'," & _
                   "ps_non_col1_04='" & ps_non_col1(4) & "'," & _
                   "ps_non_col1_05='" & ps_non_col1(5) & "'," & _
                   "ps_non_col1_06='" & ps_non_col1(6) & "'," & _
                   "ps_non_col1_07='" & ps_non_col1(7) & "'," & _
                   "ps_non_col1_08='" & ps_non_col1(8) & "'," & _
                   "ps_non_col1_09='" & ps_non_col1(9) & "'," & _
                   "ps_non_col1_10='" & ps_non_col1(10) & "'," & _
                   "ps_non_col1_11='" & ps_non_col1(11) & "'," & _
                   "ps_non_col1_12='" & ps_non_col1(12) & "'," & _
                   "ps_non_col1_13='" & ps_non_col1(13) & "'," & _
                   "ps_non_col1_14='" & ps_non_col1(14) & "'," & _
                   "ps_non_col1_15='" & ps_non_col1(15) & "'," & _
                   "ps_non_col1_16='" & ps_non_col1(16) & "'," & _
                   "ps_non_col1_17='" & ps_non_col1(17) & "'," & _
                   "ps_non_col1_18='" & ps_non_col1(18) & "'," & _
                   "ps_non_col1_19='" & ps_non_col1(19) & "'," & _
                   "ps_non_col1_20='" & ps_non_col1(20) & "'," & _
                   "ps_non_col1_21='" & ps_non_col1(21) & "'," & _
                   "ps_non_col1_22='" & ps_non_col1(22) & "'," & _
                   "ps_non_col1_23='" & ps_non_col1(23) & "'," & _
                   "ps_non_col1_24='" & ps_non_col1(24) & "'," & _
                   "ps_non_col2_01='" & ps_non_col2(1) & "'," & _
                   "ps_non_col2_02='" & ps_non_col2(2) & "'," & _
                   "ps_non_col2_03='" & ps_non_col2(3) & "'," & _
                   "ps_non_col2_04='" & ps_non_col2(4) & "'," & _
                   "ps_non_col2_05='" & ps_non_col2(5) & "'," & _
                   "ps_non_col2_06='" & ps_non_col2(6) & "'," & _
                   "ps_non_col2_07='" & ps_non_col2(7) & "'," & _
                   "ps_non_col2_08='" & ps_non_col2(8) & "'," & _
                   "ps_non_col2_09='" & ps_non_col2(9) & "'," & _
                   "ps_non_col2_10='" & ps_non_col2(10) & "'," & _
                   "ps_non_col2_11='" & ps_non_col2(11) & "'," & _
                   "ps_non_col2_12='" & ps_non_col2(12) & "'," & _
                   "ps_non_col2_13='" & ps_non_col2(13) & "'," & _
                   "ps_non_col2_14='" & ps_non_col2(14) & "'," & _
                   "ps_non_col2_15='" & ps_non_col2(15) & "'," & _
                   "ps_non_col2_16='" & ps_non_col2(16) & "'," & _
                   "ps_non_col2_17='" & ps_non_col2(17) & "'," & _
                   "ps_non_col2_18='" & ps_non_col2(18) & "'," & _
                   "ps_non_col2_19='" & ps_non_col2(19) & "'," & _
                   "ps_non_col2_20='" & ps_non_col2(20) & "'," & _
                   "ps_non_col2_21='" & ps_non_col2(21) & "'," & _
                   "ps_non_col2_22='" & ps_non_col2(22) & "'," & _
                   "ps_non_col2_23='" & ps_non_col2(23) & "'," & _
                   "ps_non_col2_24='" & ps_non_col2(24) & "' " & _
                   "WHERE id=" & test_id
    Else
        ' If not exists → INSERT
        sqlQuery = "INSERT INTO tbl_icf_03 (" & _
                   "id, full_brk_applied, full_brk_rel_in_iso, " & _
                   "coach01, coach02, coach03, coach04, coach05, coach06, coach07, coach08, coach09, coach10, " & _
                   "coach11, coach12, coach13, coach14, coach15, coach16, coach17, coach18, coach19, coach20, " & _
                   "coach21, coach22, coach23, coach24, " & _
                   "ps_end_col1_01, ps_end_col1_02, ps_end_col1_03, ps_end_col1_04, ps_end_col1_05, ps_end_col1_06, " & _
                   "ps_end_col1_07, ps_end_col1_08, ps_end_col1_09, ps_end_col1_10, ps_end_col1_11, ps_end_col1_12, " & _
                   "ps_end_col1_13, ps_end_col1_14, ps_end_col1_15, ps_end_col1_16, ps_end_col1_17, ps_end_col1_18, " & _
                   "ps_end_col1_19, ps_end_col1_20, ps_end_col1_21, ps_end_col1_22, ps_end_col1_23, ps_end_col1_24, " & _
                   "ps_end_col2_01, ps_end_col2_02, ps_end_col2_03, ps_end_col2_04, ps_end_col2_05, ps_end_col2_06, " & _
                   "ps_end_col2_07, ps_end_col2_08, ps_end_col2_09, ps_end_col2_10, ps_end_col2_11, ps_end_col2_12, " & _
                   "ps_end_col2_13, ps_end_col2_14, ps_end_col2_15, ps_end_col2_16, ps_end_col2_17, ps_end_col2_18, " & _
                   "ps_end_col2_19, ps_end_col2_20, ps_end_col2_21, ps_end_col2_22, ps_end_col2_23, ps_end_col2_24, " & _
                   "ps_non_col1_01, ps_non_col1_02, ps_non_col1_03, ps_non_col1_04, ps_non_col1_05, ps_non_col1_06, " & _
                   "ps_non_col1_07, ps_non_col1_08, ps_non_col1_09, ps_non_col1_10, ps_non_col1_11, ps_non_col1_12, " & _
                   "ps_non_col1_13, ps_non_col1_14, ps_non_col1_15, ps_non_col1_16, ps_non_col1_17, ps_non_col1_18, " & _
                   "ps_non_col1_19, ps_non_col1_20, ps_non_col1_21, ps_non_col1_22, ps_non_col1_23, ps_non_col1_24, " & _
                   "ps_non_col2_01, ps_non_col2_02, ps_non_col2_03, ps_non_col2_04, ps_non_col2_05, ps_non_col2_06, " & _
                   "ps_non_col2_07, ps_non_col2_08, ps_non_col2_09, ps_non_col2_10, ps_non_col2_11, ps_non_col2_12, " & _
                   "ps_non_col2_13, ps_non_col2_14, ps_non_col2_15, ps_non_col2_16, ps_non_col2_17, ps_non_col2_18, " & _
                   "ps_non_col2_19, ps_non_col2_20, ps_non_col2_21, ps_non_col2_22, ps_non_col2_23, ps_non_col2_24" & _
                   ") VALUES (" & _
                   test_id & ",'" & full_brk_applied & "','" & full_brk_rel_in_iso & "','" & _
                   coach(1) & "','" & coach(2) & "','" & coach(3) & "','" & coach(4) & "','" & coach(5) & "','" & _
                   coach(6) & "','" & coach(7) & "','" & coach(8) & "','" & coach(9) & "','" & coach(10) & "','" & _
                   coach(11) & "','" & coach(12) & "','" & coach(13) & "','" & coach(14) & "','" & coach(15) & "','" & _
                   coach(16) & "','" & coach(17) & "','" & coach(18) & "','" & coach(19) & "','" & coach(20) & "','" & _
                   coach(21) & "','" & coach(22) & "','" & coach(23) & "','" & coach(24) & "','" & _
                   ps_end_col1(1) & "','" & ps_end_col1(2) & "','" & ps_end_col1(3) & "','" & ps_end_col1(4) & "','" & _
                   ps_end_col1(5) & "','" & ps_end_col1(6) & "','" & ps_end_col1(7) & "','" & ps_end_col1(8) & "','" & _
                   ps_end_col1(9) & "','" & ps_end_col1(10) & "','" & ps_end_col1(11) & "','" & ps_end_col1(12) & "','" & _
                   ps_end_col1(13) & "','" & ps_end_col1(14) & "','" & ps_end_col1(15) & "','" & ps_end_col1(16) & "','" & _
                   ps_end_col1(17) & "','" & ps_end_col1(18) & "','" & ps_end_col1(19) & "','" & ps_end_col1(20) & "','" & _
                   ps_end_col1(21) & "','" & ps_end_col1(22) & "','" & ps_end_col1(23) & "','" & ps_end_col1(24) & "','" & _
                   ps_end_col2(1) & "','" & ps_end_col2(2) & "','" & ps_end_col2(3) & "','" & ps_end_col2(4) & "','" & _
                   ps_end_col2(5) & "','" & ps_end_col2(6) & "','" & ps_end_col2(7) & "','" & ps_end_col2(8) & "','" & _
                   ps_end_col2(9) & "','" & ps_end_col2(10) & "','" & ps_end_col2(11) & "','" & ps_end_col2(12) & "','" & _
                   ps_end_col2(13) & "','" & ps_end_col2(14) & "','" & ps_end_col2(15) & "','" & ps_end_col2(16) & "','" & _
                   ps_end_col2(17) & "','" & ps_end_col2(18) & "','" & ps_end_col2(19) & "','" & ps_end_col2(20) & "','" & _
                   ps_end_col2(21) & "','" & ps_end_col2(22) & "','" & ps_end_col2(23) & "','" & ps_end_col2(24) & "','" & _
                   ps_non_col1(1) & "','" & ps_non_col1(2) & "','" & ps_non_col1(3) & "','" & ps_non_col1(4) & "','" & _
                   ps_non_col1(5) & "','" & ps_non_col1(6) & "','" & ps_non_col1(7) & "','" & ps_non_col1(8) & "','" & _
                   ps_non_col1(9) & "','" & ps_non_col1(10) & "','" & ps_non_col1(11) & "','" & ps_non_col1(12) & "','" & _
                   ps_non_col1(13) & "','" & ps_non_col1(14) & "','" & ps_non_col1(15) & "','" & ps_non_col1(16) & "','" & _
                   ps_non_col1(17) & "','" & ps_non_col1(18) & "','" & ps_non_col1(19) & "','" & ps_non_col1(20) & "','" & _
                   ps_non_col1(21) & "','" & ps_non_col1(22) & "','" & ps_non_col1(23) & "','" & ps_non_col1(24) & "','" & _
                   ps_non_col2(1) & "','" & ps_non_col2(2) & "','" & ps_non_col2(3) & "','" & ps_non_col2(4) & "','" & _
                   ps_non_col2(5) & "','" & ps_non_col2(6) & "','" & ps_non_col2(7) & "','" & ps_non_col2(8) & "','" & _
                   ps_non_col2(9) & "','" & ps_non_col2(10) & "','" & ps_non_col2(11) & "','" & ps_non_col2(12) & "','" & _
                   ps_non_col2(13) & "','" & ps_non_col2(14) & "','" & ps_non_col2(15) & "','" & ps_non_col2(16) & "','" & _
                   ps_non_col2(17) & "','" & ps_non_col2(18) & "','" & ps_non_col2(19) & "','" & ps_non_col2(20) & "','" & _
                   ps_non_col2(21) & "','" & ps_non_col2(22) & "','" & ps_non_col2(23) & "','" & ps_non_col2(24) & "')"
    End If

    ' Execute SQL query
    objConn.Execute sqlQuery

    ' Error handling
    If Err.Number <> 0 Then
        strError = "VBFN_005 Error: " & Err.Description
        timeStamp = Now

        ' Log error in text file
        Set fso = CreateObject("Scripting.FileSystemObject")
        Set file = fso.OpenTextFile(logFile, 8, True)
        file.WriteLine timeStamp & " - " & strError
        file.Close
        Err.Clear
    End If

    ' Close connection
    objConn.Close
    Set objConn = Nothing
    Set objRS = Nothing

End Sub